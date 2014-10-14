<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Clients\Models;

use Config;
use DB;
use FI\Libraries\CurrencyFormatter;

class Client extends \Eloquent {
	
	/**
	 * Guarded properties
	 * @var array
	 */
	protected $guarded = array('id');

    public static function boot()
    {
        parent::boot();

        static::creating(function($client)
        {
            $client->url_key = str_random(32);
        });
    }
	
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function invoices()
    {
    	return $this->hasMany('FI\Modules\Invoices\Models\Invoice');
    }

    public function quotes()
    {
    	return $this->hasMany('FI\Modules\Quotes\Models\Quote');
    }

    public function custom()
    {
    	return $this->hasOne('FI\Modules\CustomFields\Models\ClientCustom');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedBalanceAttribute()
    {
        $id = $this->attributes['id'];

        return CurrencyFormatter::format(DB::table('invoice_amounts')->whereIn('invoice_id', function($query) use($id)
        {
            $query->select('id')->from('invoices')->where('invoices.client_id', '=', $id);
        })->sum('balance'));
    }

    public function getFormattedPaidAttribute()
    {
        $id = $this->attributes['id'];

        return CurrencyFormatter::format(DB::table('invoice_amounts')->whereIn('invoice_id', function($query) use($id)
        {
            $query->select('id')->from('invoices')->where('invoices.client_id', '=', $id);
        })->sum('paid'));
    }

    public function getFormattedTotalAttribute()
    {
        $id = $this->attributes['id'];

        return CurrencyFormatter::format(DB::table('invoice_amounts')->whereIn('invoice_id', function($query) use($id)
        {
            $query->select('id')->from('invoices')->where('invoices.client_id', '=', $id);
        })->sum('total'));
    }

    public function getFormattedAddressAttribute()
    {
        return nl2br($this->attributes['address']);
    }

    public function getCurrencyCodeAttribute($value)
    {
        return ($value) ?: Config::get('fi.baseCurrency');
    }

    public function getInvoiceTemplateAttribute($value)
    {
        return ($value) ?: Config::get('fi.invoiceTemplate');
    }

    public function getQuoteTemplateAttribute($value)
    {
        return ($value) ?: Config::get('fi.quoteTemplate');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeKeywords($query, $keywords)
    {
    	$keywords = explode(' ', $keywords);

    	foreach ($keywords as $keyword)
    	{
    		if ($keyword)
    		{
    			$keyword = strtolower($keyword);

    			$query->where(\DB::raw("CONCAT_WS('^',LOWER(name),LOWER(email),phone)"), 'LIKE', "%$keyword%");
    		}
    	}

    	return $query;
    }

}