<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Repositories;

use FI\Modules\Quotes\Models\QuoteItemAmount;

class QuoteItemAmountRepository extends \FI\Libraries\BaseRepository {

	public function __construct(QuoteItemAmount $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $itemId
	 * @return QuoteItemAmount
	 */
	public function update($input, $itemId)
	{
		$quoteItemAmount = $this->model->where('item_id', $itemId)->first();

		$quoteItemAmount->fill($input);

		$quoteItemAmount->save();

		return $quoteItemAmount;
	}

	/**
	 * Delete a record by item id
	 * @param  int $itemId
	 * @return void
	 */
	public function deleteByItemId($itemId)
	{
		$this->model->where('item_id', $itemId)->delete();
	}
	
}