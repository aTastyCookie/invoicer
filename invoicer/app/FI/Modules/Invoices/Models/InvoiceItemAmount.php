<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Models;

use Eloquent;
use FI\Libraries\CurrencyFormatter;

class InvoiceItemAmount extends Eloquent {

	/**
	 * Guarded properties
	 * @var array
	 */
	protected $guarded = array('id');

    public function item()
    {
        return $this->belongsTo('FI\Modules\Invoices\Models\InvoiceItem');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
   
	public function getFormattedSubtotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['subtotal'], $this->item->invoice->currency_code);
	}

	public function getFormattedTaxTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['tax_total'], $this->item->invoice->currency_code);
	}

	public function getFormattedTotalAttribute()
	{
		return CurrencyFormatter::format($this->attributes['total'], $this->item->invoice->currency_code);
	}

}