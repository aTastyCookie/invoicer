<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Currencies\Models;

class Currency extends \Eloquent {

	protected $table = 'currencies';

	/**
	 * Guarded properties
	 * @var array
	 */
	protected $guarded = array('id');

	public function getFormattedPlacementAttribute()
	{
		return ($this->placement == 'before') ? trans('fi.before_amount') : trans('fi.after_amount');
	}

}