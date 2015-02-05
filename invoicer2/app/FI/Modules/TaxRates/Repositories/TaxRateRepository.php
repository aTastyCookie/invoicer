<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\TaxRates\Repositories;

use Config;
use FI\Libraries\BaseRepository;
use FI\Modules\TaxRates\Models\TaxRate;

class TaxRateRepository extends BaseRepository {

	public function __construct(TaxRate $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a paged list of records
	 * @return TaxRate
	 */
	public function getPaged()
	{
		return $this->model->orderBy('name')->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Find the id by name
	 * @param  string $name
	 * @return int
	 */
	public function findIdByName($name)
	{
		if ($taxRate = $this->model->where('name', $name)->first())
		{
			return $taxRate->id;
		}
		return null;
	}

	/**
	 * Get a list of records formatted for dropdown
	 * @return array
	 */
	public function lists()
	{
		return array('0' => trans('fi.none')) + $this->model->lists('name', 'id');
	}

}