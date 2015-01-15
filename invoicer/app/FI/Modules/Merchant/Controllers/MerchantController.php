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

use App;
use BaseController;
use Config;
use Event;
use Redirect;
use View;

class MerchantController extends BaseController {

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

	public function __construct()
	{
		$this->invoice            = App::make('InvoiceRepository');
		$this->invoiceTransaction = App::make('InvoiceTransactionRepository');
		$this->payment            = App::make('PaymentRepository');
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

		// Handle the response accordingly
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

}