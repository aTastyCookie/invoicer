<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Repositories;

use Event;
use FI\Libraries\BaseRepository;
use FI\Modules\Quotes\Models\QuoteTaxRate;

class QuoteTaxRateRepository extends BaseRepository {

	public function __construct(QuoteTaxRate $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of tax rates by quote id
	 * @param  int $quoteId
	 * @return QutoeTaxRate
	 */
	public function findByQuoteId($quoteId)
	{
		return $this->model->where('quote_id', $quoteId)->get();
	}

	/**
	 * Create a record
	 * @param  array $input
	 * @return QuoteTaxRate
	 */
	public function create($input)
	{
		$quoteTaxRate = $this->model->create($input);

		Event::fire('quote.modified', array($quoteTaxRate->quote));

		return $quoteTaxRate;
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $quoteId
	 * @param  int $taxRateId
	 * @return QuoteTaxRate
	 */
	public function updateQuoteTaxRate($input, $quoteId, $taxRateId)
	{
		$quoteTaxRate = $this->model->where('quote_id', $quoteId)->where('tax_rate_id', $taxRateId)->first();

		$quoteTaxRate->fill($input);

		$quoteTaxRate->save();

		return $quoteTaxRate;
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$quoteTaxRate = $this->model->find($id);

		$quote = $quoteTaxRate->quote;

		$quoteTaxRate->delete();

		Event::fire('quote.modified', array($quote));
	}
	
}