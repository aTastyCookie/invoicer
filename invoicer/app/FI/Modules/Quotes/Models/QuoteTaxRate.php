<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Models;

use Eloquent;
use FI\Libraries\CurrencyFormatter;

class QuoteTaxRate extends Eloquent {

	/**
	 * Guarded properties
	 * @var array
	 */
	protected $guarded = array('id');

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
   
	public function taxRate()
	{
		return $this->belongsTo('FI\Modules\TaxRates\Models\TaxRate');
	}

	public function quote()
	{
		return $this->belongsTo('FI\Modules\Quotes\Models\Quote');
	}

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
   
	public function getFormattedTaxTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['tax_total'], $this->quote->currency_code);
	}

}