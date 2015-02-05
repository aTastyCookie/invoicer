<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Controllers;

use Config;
use Event;
use Omnipay\Omnipay;
use Redirect;
use View;

class MerchantController extends \BaseController {

	/**
	 * Invoice Repository
	 * @var InvoiceRepository
	 */
	protected $invoice;

	/**
	 * Invoice Transaction Repository
	 * @var InvoiceTransactionRepository
	 */
	protected $invoiceTransaction;

	/**
	 * Payment Repository
	 * @var PaymentRepository
	 */
	protected $payment;

	/**
	 * Dependency injection
	 * @param InvoiceRepository $invoice
	 * @param InvoiceTransactionRepository $invoiceTransaction
	 * @param PaymentRepository $payment
	 */
	public function __construct($invoice, $invoiceTransaction, $payment)
	{
		$this->invoice            = $invoice;
		$this->invoiceTransaction = $invoiceTransaction;
		$this->payment            = $payment;
	}

	/**
	 * Handles the first call
	 * @param  string $urlKey
	 * @return mixed
	 */
	public function invoicePay($urlKey)
	{
			
		// Get the selected merchant
		$merchant = Config::get('payments.default');

		// Path to the merchant library
		$merchantLib = '\\FI\\Modules\\Merchant\\Libraries\\' . $merchant;
	        //var_dump($merchant);
		// Create the gateway
		$gateway = $merchantLib::createGateway();

		// Get the invoice
		$invoice = $this->invoice->findByUrlKey($urlKey);
		
		// Define some default purchase parameters and get any additional from
		// the merchant driver
		$purchaseParams = $merchantLib::setPurchaseParameters(array(
			'amount'      => $invoice->amount->balance,
			'description' => trans('fi.invoice') . ' #' . $invoice->number,
			'currency'    => $invoice->currency_code,
		), array('urlKey' => $urlKey, 'post' => $_POST));

		// Get the response
		$response = $gateway->purchase($purchaseParams)->send();
		
		/// Handle the response accordingly
		if ($response->isSuccessful())
		{
			// This was a successful on-site transaction.
			// Record the transaction.
			$this->recordSuccessTransaction($response, $invoice);

			// Redirect back to the client invoice
			return Redirect::route('clientCenter.invoice.show', array($invoice->url_key));
		}
		elseif ($response->isRedirect())
		{
			// This is an off-site transaction. Redirect off-site.
			$response->redirect();
		}
		else
		{
			// Record the failed transaction
			$this->recordFailTransaction($response, $invoice);

			exit($response->getMessage());
		}

	}

	/**
	 * Displays credit card modal for on-site gateways
	 * @param  string $urlKey
	 * @return View
	 */
	public function invoiceModalCc($urlKey)
	{
		return View::make('merchant/_modal_' . strtolower(Config::get('payments.default')))
		->with('invoice', $this->invoice->findByUrlKey($urlKey));
	}

	/**
	 * Handle the off-site return, obviously only after an off-site redirect
	 * @param  string $urlKey
	 * @return mixed
	 */
	public function invoiceReturn($urlKey)
	{
		
		// Get the selected merchant
		$merchant = Config::get('payments.default');

		// Path to the merchant library
		$merchantLib = '\\FI\\Modules\\Merchant\\Libraries\\' . $merchant;

		// Create the gateway
		$gateway = $merchantLib::createGateway();

		// Get the invoice
		$invoice = $this->invoice->findByUrlKey($urlKey);
		
		// Define some default purchase parameters and get any additional from
		// the merchant driver
		$purchaseParams = $merchantLib::setPurchaseParameters(array(
			'amount'      => $invoice->amount->balance,
			'description' => trans('fi.invoice') . ' #' . $invoice->number,
			'currency'    => $invoice->currency_code
		), array('urlKey' => $urlKey, 'post' => $_POST));
		
		// Get the response
		$response = $gateway->completePurchase($purchaseParams)->send();
		

		// Handle the response accordingly
		if ($response->isSuccessful())
		{
			// Record the successful transaction
			$this->recordSuccessTransaction($response, $invoice);

			// Redirect back to the client invoice
			return Redirect::route('clientCenter.invoice.show', array($invoice->url_key));
		}
		else
		{
			// Record the failed transaction
			$this->recordFailTransaction($response, $invoice);

			exit($response->getMessage());
		}
	}

	/**
	 * Handle a canceled return
	 * @param  string $urlKey
	 * @return Redirect
	 */
	public function invoiceCancel($urlKey)
	{
		// Redirect back to the client invoice
		return Redirect::route('clientCenter.invoice.show', array($urlKey));
	}

	/**
	 * Display when online payments are disabled
	 * @return View
	 */
	public function disabled()
	{
		// Display the disabled message
		return View::make('merchant.disabled');
	}

	/**
	 * Record successful transation
	 * @param  Gateway Response $response
	 * @param  Invoice $invoice
	 * @return void
	 */
	public function recordSuccessTransaction($response, $invoice)
	{
		$this->invoiceTransaction->create(array('invoice_id' => $invoice->id, 'is_successful' => 1, 'transaction_reference' => $response->getTransactionReference()));

		$payment = $this->payment->create(array('invoice_id' => $invoice->id, 'payment_method_id' => (Config::get('fi.onlinePaymentMethod') ?: 0), 'amount' => $invoice->amount->balance, 'paid_at' => date('Y-m-d H:i:s'), 'note' => ''));

		Event::fire('payment.created', array($payment));

		$invoice->activities()->create(array('activity' => 'public.paid'));
	}

	/**
	 * Record failed transaction
	 * @param  Gateway Response $response
	 * @param  Invoice $invoice
	 * @return void
	 */
	public function recordFailTransaction($response, $invoice)
	{
		$this->invoiceTransaction->create(array('invoice_id' => $invoice->id, 'is_successful' => 0, 'transaction_reference' => $response->getMessage()));
	}

	/* add YandexMoney */
	public function invoiceYandexMoney()
	{
		
		if (isset($_GET['action']) && $_GET['action'] == 'PaymentSuccess') {
			$id = (int)$_GET['orderNumber'];
			$invoice = $this->invoice->find($id);
			return Redirect::route('clientCenter.invoice.show', array($invoice->url_key));
		}elseif(isset($_POST['orderNumber'])) {
			$id = (int)$_POST['orderNumber'];
		}elseif(isset($_POST['label'])){
			$id = (int)$_POST['label'];
		}else{
			die('NO INPUT DATA');
		}
		
		// Get the invoice
		$invoice = $this->invoice->find($id);
		
		// Get the selected merchant
		$merchant = Config::get('payments.default');

		// Path to the merchant library
		$merchantLib = '\\FI\\Modules\\Merchant\\Libraries\\' . $merchant;

		// Create the gateway
		$gateway = $merchantLib::createGateway();
		// Define some default purchase parameters and get any additional from
		// the merchant driver
		$purchaseParams = $merchantLib::setPurchaseParameters(array(
			'amount'      => $invoice->amount->balance,
			'description' => trans('fi.invoice') . ' #' . $invoice->number,
			'currency'    => $invoice->currency_code
		), array('urlKey' => $invoice->url_key, 'post' => $_POST));
		
		if (isset($_POST['action']) && $_POST['action'] == 'checkOrder') {
			$response = $gateway->authorize($purchaseParams)->send();
		}else {
			if (isset($_POST['label'])) {
				$response = $gateway->authorize($purchaseParams)->send();
				if ($response->isSuccessful()) {
					$this->recordSuccessTransaction($response, $invoice);
				}else {
					header($response->getMessage());
					exit;
				}
			}else {
				// Get the response
				$response = $gateway->completePurchase($purchaseParams)->send();
				if ($response->isSuccessful()) {
					$this->recordSuccessTransaction($response, $invoice);
				}
			}
		}
		header("Content-type: text/xml; charset=utf-8");
		exit($response->getMessage());
	}


}