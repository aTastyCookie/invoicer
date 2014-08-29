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

use FI\Libraries\CurrencyFormatter;
use FI\Modules\Invoices\Models\InvoiceAmount;

class InvoiceAmountRepository extends \FI\Libraries\BaseRepository {

	public function __construct(InvoiceAmount $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of records by invoice id
	 * @param  int $invoiceId
	 * @return InvoiceAmount
	 */
	public function findByInvoiceId($invoiceId)
	{
		return $this->model->where('invoice_id', '=', $invoiceId)->first();
	}

	/**
	 * Create a record
	 * @param  integer $invoiceId
	 * @return InvoiceAmount
	 */
	public function create($invoiceId)
	{
		return $this->model->create(
			array(
				'invoice_id'     => $invoiceId,
				'item_subtotal'  => 0,
				'item_tax_total' => 0,
				'tax_total'      => 0,
				'total'          => 0,
				'paid'           => 0,
				'balance'        => 0
			)
		);
	}

	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $invoiceId
	 * @return InvoiceAmount
	 */
	public function update($input, $invoiceId)
	{
		$invoiceAmount = $this->model->where('invoice_id', $invoiceId)->first();

		$invoiceAmount->fill($input);

		$invoiceAmount->save();

		return $invoiceAmount;
	}

	public function getTotalDraft()
	{
		return CurrencyFormatter::format($this->model->whereHas('invoice', function($q)
		{
			$q->draft();
		})->sum('balance'));
	}

	public function getTotalSent()
	{
		return CurrencyFormatter::format($this->model->whereHas('invoice', function($q)
		{
			$q->sent();
		})->sum('balance'));
	}

	public function getTotalPaid()
	{
		return CurrencyFormatter::format($this->model->sum('paid'));
	}

	public function getTotalOverdue()
	{
		return CurrencyFormatter::format($this->model->whereHas('invoice', function($q)
		{
			$q->overdue();
		})->sum('balance'));
	}
}