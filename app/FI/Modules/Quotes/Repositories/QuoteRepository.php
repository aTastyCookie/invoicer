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

use Config;
use Event;
use FI\Modules\Quotes\Models\Quote;
use FI\Statuses\QuoteStatuses;

class QuoteRepository extends \FI\Libraries\BaseRepository {

	public function __construct(Quote $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a paged list of records
	 * @param  string  $status
	 * @param  string  $filter
	 * @return Quote
	 */
	public function getPagedByStatus($status = 'all', $filter = null)
	{
		$quote = $this->model->has('amount')->with(array('amount', 'client'))->orderBy('created_at', 'DESC')->orderBy('number', 'DESC');

		switch ($status)
		{
			case 'draft':
				$quote->draft();
				break;
			case 'sent':
				$quote->sent();
				break;
			case 'viewed':
				$quote->viewed();
				break;
			case 'approved':
				$quote->approved();
				break;
			case 'rejected':
				$quote->rejected();
				break;
			case 'canceled':
				$quote->canceled();
				break;
		}

		if ($filter)
		{
			$quote->keywords($filter);
		}

		return $quote->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Get a limited list of all records
	 * @param  int $limit
	 * @return Quote
	 */
	public function getRecent($limit)
	{
		return $this->model->has('amount')->with(array('amount', 'client'))->orderBy('created_at', 'DESC')->limit($limit)->get();
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return Quote
	 */
	public function find($id)
	{
		return $this->model->with('items.amount', 'items.taxRate', 'taxRates.taxRate')->find($id);
	}

	/**
	 * Find a quote id by number
	 * @param  string $number
	 * @return int
	 */
	public function findIdByNumber($number)
	{
		if ($quote = $this->model->where('number', $number)->first())
		{
			return $quote->id;
		}
		return null;
	}

	/**
	 * Get a record by url key
	 * @param  string $urlKey
	 * @return Quote
	 */
	public function findByUrlKey($urlKey)
	{
		return $this->model->where('url_key', $urlKey)->first();
	}

	/**
	 * Create a record
	 * @param  array $input
	 * @return Quote
	 */
	public function create($input)
	{
		$quote = $this->model->create($input);

		Event::fire('quote.created', array($quote));

		return $quote;
	}

	public function approve($urlKey)
	{
		$quote = $this->findByUrlKey($urlKey);

		$quote->quote_status_id = QuoteStatuses::getStatusId('approved');

		$quote->save();

		return $quote;
	}

	public function reject($urlKey)
	{
		$quote = $this->findByUrlKey($urlKey);

		$quote->quote_status_id = QuoteStatuses::getStatusId('rejected');

		$quote->save();

		return $quote;
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$quote = $this->model->find($id);

		foreach ($quote->items as $item)
		{
			$item->amount()->delete();
			$item->delete();
		}

		$quote->taxRates()->delete();
		$quote->custom()->delete();
		$quote->amount()->delete();
		$quote->activities()->delete();

		$quote->delete();		
	}

}