<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Payments\Repositories;

use Config;
use Event;

use FI\Modules\Payments\Models\Payment;

class PaymentRepository extends \FI\Libraries\BaseRepository {

	public function __construct(Payment $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a paged list of records
	 * @param  string $filter
	 * @return Payment
	 */
	public function getPaged($filter = null)
	{
		if (!$filter)
		{
			return $this->model->orderBy('paid_at', 'desc')->orderBy('created_at', 'desc')->paginate(Config::get('fi.defaultNumPerPage'));
		}
		else
		{
			return $this->model->orderBy('paid_at', 'desc')->orderBy('created_at', 'desc')->keywords($filter)->paginate(Config::get('fi.defaultNumPerPage'));
		}
	}

	/**
	 * Get the total amount paid by invoice id
	 * @param  int $invoiceId
	 * @return Payment
	 */
	public function getTotalPaidByInvoiceId($invoiceId)
	{
		return $this->model->where('invoice_id', $invoiceId)->sum('amount');
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return Payment
	 */
	public function find($id)
	{
		return $this->model->with('custom')->find($id);
	}

	/**
	 * Get a list of records by invoice id
	 * @param  int $invoiceId
	 * @return Payment
	 */
	public function findByInvoiceId($invoiceId)
	{
		return $this->model->where('invoice_id', '=', $invoiceId)->get();
	}

	/**
	 * Create a record
	 * @param  array $input
	 * @return Payment
	 */
	public function create($input)
	{
		$payment = $this->model->create($input);

		Event::fire('invoice.modified', array($payment->invoice));

		return $payment;
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $id
	 * @return Payment
	 */
	public function update($input, $id)
	{
		$payment = $this->model->find($id);

		$payment->fill($input);

		$payment->save();

		Event::fire('invoice.modified', array($payment->invoice));

		return $payment;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$payment = $this->model->find($id);

		$invoice = $payment->invoice;

		$payment->custom()->delete();

		$payment->delete($id);

		Event::fire('invoice.modified', array($invoice));
	}
	
}