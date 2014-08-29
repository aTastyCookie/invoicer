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

use Event;

use FI\Modules\Invoices\Models\InvoiceTaxRate;

class InvoiceTaxRateRepository extends \FI\Libraries\BaseRepository {

	public function __construct(InvoiceTaxRate $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a single record by invoice id
	 * @param  int $invoiceId
	 * @return InvoiceTaxRate
	 */
	public function findByInvoiceId($invoiceId)
	{
		return $this->model->where('invoice_id', $invoiceId)->get();
	}
	
	/**
	 * Create a record
	 * @param  array $input
	 * @return InvoiceTaxRate
	 */
	public function create($input)
	{
		$invoiceTaxRate = $this->model->create($input);

		Event::fire('invoice.modified', $invoiceTaxRate->invoice);

		return $invoiceTaxRate;
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $invoiceId
	 * @param  int $taxRateId
	 * @return InvoiceTaxRate
	 */
	public function updateInvoiceTaxRate($input, $invoiceId, $taxRateId)
	{
		$invoiceTaxRate = $this->model->where('invoice_id', $invoiceId)->where('tax_rate_id', $taxRateId)->first();

		$invoiceTaxRate->fill($input);

		$invoiceTaxRate->save();

		return $invoiceTaxRate;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$invoiceTaxRate = $this->model->find($id);

		$invoice = $invoiceTaxRate->invoice;

		$invoiceTaxRate->delete();

		Event::fire('invoice.modified', $invoice);
	}
	
}