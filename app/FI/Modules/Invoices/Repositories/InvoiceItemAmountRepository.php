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

use FI\Modules\Invoices\Models\InvoiceItemAmount;

class InvoiceItemAmountRepository extends \FI\Libraries\BaseRepository {

	public function __construct(InvoiceItemAmount $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $itemId
	 * @return InvoiceItemAmount
	 */
	public function update($input, $itemId)
	{
		$invoiceItemAmount = $this->model->where('item_id', $itemId)->first();

		$invoiceItemAmount->fill($input);

		$invoiceItemAmount->save();

		return $invoiceItemAmount;
	}

	/**
	 * Delete a record based on the item id
	 * @param  int $itemId
	 * @return void
	 */
	public function deleteByItemId($itemId)
	{
		$this->model->where('item_id', $itemId)->delete();
	}
	
}