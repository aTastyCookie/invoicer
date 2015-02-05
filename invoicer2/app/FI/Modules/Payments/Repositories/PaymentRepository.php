<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Payments\Repositories;

use Config;
use Event;
use FI\Libraries\BaseRepository;

use FI\Modules\Payments\Models\Payment;

class PaymentRepository extends BaseRepository {

	public function __construct(Payment $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a paged list of records
	 * @param  string $filter
	 * @return Payment
	 */
	public function getPaged($filter = null, $clientId = null)
	{
        $payments = $this->model->orderBy('paid_at', 'desc')->orderBy('created_at', 'desc');

        if ($filter)
        {
            $payments->keywords($filter);
		}

        if ($clientId)
        {
            $payments->whereHas('invoice', function($query) use($clientId)
            {
                $query->where('client_id', $clientId);
            });
        }

        return $payments->paginate(Config::get('fi.defaultNumPerPage'));
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

    public function getByClientId($clientId)
    {
        return $this->model->whereHas('invoice', function($query) use($clientId)
        {
            $query->where('client_id', $clientId);
        })->orderBy('paid_at', 'desc')->get();
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