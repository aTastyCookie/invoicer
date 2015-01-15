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
use FI\Libraries\NumberFormatter;

class QuoteAmount extends Eloquent {

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
   
    public function quote()
    {
    	return $this->belongsTo('FI\Modules\Quotes\Models\Quote');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

	public function getFormattedItemSubtotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['item_subtotal'], $this->quote->currency_code);
	}

	public function getFormattedItemTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['item_subtotal'] + $this->attributes['item_tax_total']);
	}

	// Returns the item level tax
	public function getFormattedItemTaxTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['item_tax_total']);
	}

	// Returns the quote level tax
	public function getFormattedTaxTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['tax_total']);
	}

	// Returns the entire amount of tax for the quote (formatted as currency)
	public function getFormattedTotalTaxAttribute()
	{
		return CurrencyFormatter::format($this->attributes['item_tax_total'] + $this->attributes['tax_total'], $this->quote->currency_code);
	}

    // Returns the entire amount of tax for the quote
    public function getTotalTaxAttribute()
    {
        return NumberFormatter::format($this->attributes['item_tax_total'] + $this->attributes['tax_total']);
    }

	public function getFormattedTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['total'], $this->quote->currency_code);
	}

}