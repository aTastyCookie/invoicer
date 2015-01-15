<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\CustomFields\Models;

use Eloquent;

class CustomField extends Eloquent {

    /**
     * Guarded properties
     * @var array
     */	
	protected $guarded = array('id');

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeForTable($query, $table)
    {
    	return $query->where('table_name', '=', $table);
    }

}