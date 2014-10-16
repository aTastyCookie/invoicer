<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\ItemLookups\Repositories;

use Config;
use FI\Libraries\NumberFormatter;
use FI\Modules\ItemLookups\Models\ItemLookup;

class ItemLookupRepository extends \FI\Libraries\BaseRepository {

	public function __construct(ItemLookup $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Get a paged list of records
	 * @return ItemLookup
	 */
	public function getPaged()
	{
		return $this->model->orderBy('name')->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Provides a json encoded array of matching records
	 * @param  string $name
	 * @return json
	 */
	public function lookup($query)
	{
		$items = $this->model->orderBy('name')->where('name', 'like', '%' . $query . '%')->get();

		$return = array();

		foreach ($items as $item)
		{
			$return[] = array(
				'item_name'        => $item->name,
				'item_description' => $item->description,
				'item_price'       => NumberFormatter::format($item->price)
			);
		}

		return json_encode($return);
	}
	
}