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

use FI\Libraries\CurrencyFormatter;
use FI\Modules\Quotes\Models\QuoteAmount;

class QuoteAmountRepository extends \FI\Libraries\BaseRepository {

	public function __construct(QuoteAmount $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of records by invoice id
	 * @param  int $quoteId
	 * @return QuoteAmount
	 */
	public function findByQuoteId($quoteId)
	{
		return $this->model->where('quote_id', '=', $quoteId)->first();
	}
	
	/**
	 * Create a record
	 * @param  integer $quoteId
	 * @return QuoteAmount
	 */
	public function create($quoteId)
	{
		return $this->model->create(
			array(
				'quote_id'       => $quoteId,
				'item_subtotal'  => 0,
				'item_tax_total' => 0,
				'tax_total'      => 0,
				'total'          => 0
			)
		);
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $quoteId
	 * @return QuoteAmount
	 */
	public function update($input, $quoteId)
	{
		$quoteAmount = $this->model->where('quote_id', $quoteId)->first();

		$quoteAmount->fill($input);

		$quoteAmount->save();

		return $quoteAmount;
	}

	public function getTotalDraft()
	{
		return CurrencyFormatter::format($this->model->whereHas('quote', function($q)
		{
			$q->draft();
		})->sum('total'));
	}

	public function getTotalSent()
	{
		return CurrencyFormatter::format($this->model->whereHas('quote', function($q)
		{
			$q->sent();
		})->sum('total'));
	}

	public function getTotalApproved()
	{
		return CurrencyFormatter::format($this->model->whereHas('quote', function($q)
		{
			$q->approved();
		})->sum('total'));
	}

	public function getTotalRejected()
	{
		return CurrencyFormatter::format($this->model->whereHas('quote', function($q)
		{
			$q->rejected();
		})->sum('total'));
	}
}