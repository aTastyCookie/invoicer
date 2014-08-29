<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Repositories;

use Event;
use FI\Modules\Quotes\Models\QuoteItem;
use FI\Modules\Quotes\Models\QuoteItemAmount;

class QuoteItemRepository extends \FI\Libraries\BaseRepository {

	public function __construct(QuoteItem $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of records by quote id
	 * @param  int $quoteId
	 * @return QuoteItem
	 */
	public function findByQuoteId($quoteId)
	{
		return $this->model->orderBy('display_order')->where('quote_id', '=', $quoteId)->get();
	}
	
	/**
	 * Create a record
	 * @param  array $input
	 * @return QuoteItem
	 */
	public function create($input)
	{
		$quoteItem = $this->model->create($input);

		Event::fire('quote.item.created', $quoteItem->id);

		return $quoteItem;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return string
	 */
	public function delete($id)
	{
		$quoteItem = $this->model->find($id);

		$quote = $quoteItem->quote;

		$quoteItem->amount->delete();
		$quoteItem->delete();

		Event::fire('quote.modified', $quote);
	}
	
}