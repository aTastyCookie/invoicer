<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\PaymentMethods\Models;

class PaymentMethod extends \Eloquent {

	/**
	 * Guarded properties
	 * @var array
	 */
	protected $guarded = array('id');

}