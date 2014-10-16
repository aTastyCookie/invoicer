<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\PaymentMethods\Repositories;

use Config;
use FI\Modules\PaymentMethods\Models\PaymentMethod;

class PaymentMethodRepository extends \FI\Libraries\BaseRepository {

	public function __construct(PaymentMethod $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a paged list of records
	 * @return PaymentMethod
	 */
	public function getPaged()
	{
		return $this->model->paginate(Config::get('fi.defaultNumPerPage'));
	}

	public function firstOrCreate($paymentMethod)
	{
		return $this->model->firstOrCreate(array('name' => $paymentMethod));
	}

	/**
	 * Get a list of records formatted for dropdown
	 * @return PaymentMethod
	 */
	public function lists()
	{
		return $this->model->lists('name', 'id');
	}

}