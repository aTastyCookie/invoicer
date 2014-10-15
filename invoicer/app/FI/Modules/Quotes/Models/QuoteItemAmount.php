<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Models;

use FI\Libraries\CurrencyFormatter;

class QuoteItemAmount extends \Eloquent {

	/**
	 * Guarded properties
	 * @var array
	 */
	protected $guarded = array('id');

    public function item()
    {
        return $this->belongsTo('FI\Modules\Quotes\Models\QuoteItem');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
   
	public function getFormattedSubtotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['subtotal'], $this->item->quote->currency_code);
	}

	public function getFormattedTaxTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['tax_total'], $this->item->quote->currency_code);
	}

	public function getFormattedTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['total'], $this->item->quote->currency_code);
	}

}