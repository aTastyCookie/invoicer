<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Repositories;

use Event;
use FI\Libraries\BaseRepository;
use FI\Modules\Invoices\Models\InvoiceItem;

class InvoiceItemRepository extends BaseRepository {

	public function __construct(InvoiceItem $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of records by invoice id
	 * @param  int $invoiceId
	 * @return InvoiceItem
	 */
	public function findByInvoiceId($invoiceId)
	{
		return $this->model->orderBy('display_order')->where('invoice_id', '=', $invoiceId)->get();
	}

	/**
	 * Create a record
	 * @param  array $input
	 * @return InvoiceItem
	 */
	public function create($input)
	{
		$item = $this->model->create($input);

		Event::fire('invoice.item.created', $item->id);

		return $item;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$invoiceItem = $this->model->find($id);

		$invoice = $invoiceItem->invoice;

		$invoiceItem->amount->delete();
		$invoiceItem->delete();

		Event::fire('invoice.modified', $invoice);
	}
	
}