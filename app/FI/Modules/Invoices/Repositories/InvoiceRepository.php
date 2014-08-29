<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Repositories;

use Config;
use Event;
use FI\Modules\Invoices\Models\Invoice;

class InvoiceRepository extends \FI\Libraries\BaseRepository {

	public function __construct(Invoice $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of records by status
	 * @param  string  $status
	 * @param  string  $filter
	 * @return Invoice
	 */
	public function getPagedByStatus($status = 'all', $filter = null)
	{
		$invoice = $this->model->has('amount')->with(array('amount', 'client'))->orderBy('created_at', 'DESC')->orderBy('number', 'desc');

		switch ($status)
		{
			case 'draft':
				$invoice->draft();
				break;
			case 'sent':
				$invoice->sent();
				break;
			case 'viewed':
				$invoice->viewed();
				break;
			case 'paid':
				$invoice->paid();
				break;
			case 'canceled':
				$invoice->canceled();
				break;
			case 'overdue':
				$invoice->overdue();
				break;
		}

		if ($filter)
		{
			$invoice->keywords($filter);
		}

		return $invoice->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Get a limited list of all invoices
	 * @param  int $limit
	 * @return Invoice
	 */
	public function getRecent($limit)
	{
		return $this->model->has('amount')->with(array('amount', 'client'))->orderBy('created_at', 'DESC')->limit($limit)->get();
	}

	/**
	 * Get a limited list of overdue records
	 * @param  int $limit
	 * @return Invoice
	 */
	public function getRecentOverdue($limit)
	{
		return $this->model->has('amount')->overdue()->with(array('amount', 'client'))->orderBy('due_at')->limit($limit)->get();
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return Invoice
	 */
	public function find($id)
	{
		return $this->model->with(array('items.amount', 'custom'))->find($id);
	}

	/**
	 * Find an invoice id by number
	 * @param  string $number
	 * @return int
	 */
	public function findIdByNumber($number)
	{
		if ($invoice = $this->model->where('number', $number)->first())
		{
			return $invoice->id;
		}
		return null;
	}

	/**
	 * Get a record by url key
	 * @param  string $urlKey
	 * @return Invoice
	 */
	public function findByUrlKey($urlKey)
	{
		return $this->model->where('url_key', $urlKey)->first();
	}
	
	/**
	 * Create a record
	 * @param  array $input
	 * @param  boolean $includeDefaultTaxRate
	 * @return Invoice
	 */
	public function create($input, $includeDefaultTaxRate = true)
	{
		$invoice = $this->model->create($input);

		Event::fire('invoice.created', array($invoice, $includeDefaultTaxRate));

		return $invoice;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$invoice = $this->model->find($id);

		foreach ($invoice->items as $item)
		{
			$item->amount()->delete();
			$item->delete();
		}

		$invoice->taxRates()->delete();
		$invoice->custom()->delete();

		foreach ($invoice->payments as $payment)
		{
			$payment->custom()->delete();
		}

		$invoice->payments()->delete();
		$invoice->amount()->delete();
		$invoice->activities()->delete();
		$invoice->recurring()->delete();

		$invoice->delete();
	}
	
}