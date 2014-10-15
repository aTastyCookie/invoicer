<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Payments\Controllers;

use App;
use Config;
use Event;
use FI\Libraries\CustomFields;
use FI\Libraries\DateFormatter;
use FI\Libraries\NumberFormatter;
use Input;
use Mail;
use Redirect;
use Response;
use Swift_TransportException;
use View;

class PaymentController extends \BaseController {

	/**
	 * Payment repository
	 * @var PaymentRepository
	 */
	protected $payment;

	/**
	 * Payment validator
	 * @var PaymentValidator
	 */
	protected $validator;
	
	/**
	 * Dependency injection
	 * @param PaymentRepository $payment
	 * @param PaymentValidator $validator
	 */
	public function __construct($payment, $validator)
	{
		$this->payment       = $payment;
		$this->validator     = $validator;
	}

	/**
	 * Display paginated list
	 * @return View
	 */
	public function index()
	{
		$payments = $this->payment->getPaged(Input::get('search'));

		return View::make('payments.index')
		->with('payments', $payments)
		->with('mailConfigured', (Config::get('fi.mailDriver')) ? true : false)
		->with('filterRoute', route('payments.index'));
	}

	/**
	 * Display form for existing record
	 * @param  int $paymentId
	 * @param  int $invoiceId
	 * @return View
	 */
	public function edit($paymentId, $invoiceId)
	{
		$invoice = App::make('InvoiceRepository');

		$payment = $this->payment->find($paymentId);
		$invoice = $invoice->find($invoiceId);
		
		return View::make('payments.form')
		->with('editMode', true)
		->with('payment', $payment)
		->with('paymentMethods', App::make('PaymentMethodRepository')->lists())
		->with('invoice', $invoice)
		->with('customFields', App::make('CustomFieldRepository')->getByTable('payments'));
	}

	/**
	 * Validate and handle existing record form submission
	 * @param  int $paymentId
	 * @param  int $invoiceId
	 * @return RedirectResponse
	 */
	public function update($paymentId, $invoiceId)
	{
		$input = Input::all();

		if (Input::has('custom'))
		{
			$custom = $input['custom'];
			unset($input['custom']);
		}

		$input['paid_at'] = DateFormatter::unformat($input['paid_at']);
		$input['amount']  = NumberFormatter::unformat($input['amount']);

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('payments.edit', array($paymentId, $invoiceId))
			->with('editMode', true)
			->withErrors($validator)
			->withInput();
		}

		$this->payment->update($input, $paymentId);

		if (Input::has('custom'))
		{
			App::make('PaymentCustomRepository')->save($custom, $paymentId);
		}

		return Redirect::route('payments.index')
		->with('alertInfo', trans('fi.record_successfully_updated'));
	}

	/**
	 * Delete a record
	 * @param  int $paymentId
	 * @param  int $invoiceId
	 * @return RedirectResponse
	 */
	public function delete($paymentId, $invoiceId)
	{
		$this->payment->delete($paymentId);

		return Redirect::route('payments.index')
		->with('alert', trans('fi.record_successfully_deleted'));
	}

	/**
	 * Display the enter payment modal form
	 * @return View
	 */
	public function modalEnterPayment()
	{
		$date = DateFormatter::format();
		
		return View::make('payments._modal_enter_payment')
		->with('invoice_id', Input::get('invoice_id'))
		->with('balance', App::make('InvoiceRepository')->find(Input::get('invoice_id'))->amount->formatted_numeric_balance)
		->with('date', $date)
		->with('paymentMethods', App::make('PaymentMethodRepository')->lists())
		->with('customFields', App::make('CustomFieldRepository')->getByTable('payments'))
		->with('redirectTo', Input::get('redirectTo'))
		->with('mailConfigured', (Config::get('fi.mailDriver')) ? true : false);
	}

	/**
	 * Attempt to save payment from modal
	 * @return json
	 */
	public function ajaxStore()
	{
		// Validate the input and return correct response
		$input = Input::all();

		$custom = (array) json_decode($input['custom']);
		
		unset($input['custom'], $input['email_payment_receipt']);

		$input['paid_at'] = DateFormatter::unformat($input['paid_at']);
		$input['amount']  = NumberFormatter::unformat($input['amount']);

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'errors' => $validator->messages()->toArray()
			), 400);
		}

		$payment = $this->payment->create($input);

		App::make('PaymentCustomRepository')->save($custom, $payment->id);

		if (Input::get('email_payment_receipt') == 'true')
		{
			Event::fire('payment.created', array($payment, false));
		}

		return Response::json(array('success' => true), 200);
	}

}