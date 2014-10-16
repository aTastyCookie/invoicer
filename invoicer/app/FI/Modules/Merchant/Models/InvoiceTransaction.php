<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Models;

class InvoiceTransaction extends \Eloquent {

	protected $table = 'invoice_transactions';

	protected $guarded = array('id');

}