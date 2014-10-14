<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Payments\Models;

use DB;
use FI\Libraries\DateFormatter;
use FI\Libraries\CurrencyFormatter;
use FI\Libraries\NumberFormatter;

class Payment extends \Eloquent {

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
   
    public function custom()
    {
        return $this->hasOne('FI\Modules\CustomFields\Models\PaymentCustom');
    }

    public function invoice()
    {
    	return $this->belongsTo('FI\Modules\Invoices\Models\Invoice');
    }

    public function paymentMethod()
    {
    	return $this->belongsTo('FI\Modules\PaymentMethods\Models\PaymentMethod');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedPaidAtAttribute()
    {
    	return DateFormatter::format($this->attributes['paid_at']);
    }

    public function getFormattedAmountAttribute()
    {
    	return CurrencyFormatter::format($this->attributes['amount'], $this->invoice->currency_code);
    }

    public function getFormattedNumericAmountAttribute()
    {
        return NumberFormatter::format($this->attributes['amount']);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
   
    public function scopeByDateRange($query, $from, $to)
    {
        return $query->where('paid_at', '>=', $from)->where('paid_at', '<=', $to);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where(\DB::raw('YEAR(paid_at)'), '=', $year);
    }

    public function scopeKeywords($query, $keywords)
    {
        $keywords = strtolower($keywords);

        $query->where('created_at', 'like', '%'.$keywords.'%')
        ->orWhereIn('invoice_id', function($query) use($keywords)
            {
                $query->select('id')->from('invoices')->where(DB::raw('lower(number)'), 'like', '%'.$keywords.'%')
                ->orWhereIn('client_id', function($query) use($keywords)
                    {
                        $query->select('id')->from('clients')->where(DB::raw('lower(name)'), 'like', '%'.$keywords.'%');
                    });
            })
        ->orWhereIn('payment_method_id', function($query) use ($keywords)
        {
            $query->select('id')->from('payment_methods')->where(DB::raw('lower(name)'), 'like', '%'.$keywords.'%');
        });

        return $query;
    }

}