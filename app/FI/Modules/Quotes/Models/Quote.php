<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Models;

use App;
use Config;
use DB;
use FI\Libraries\DateFormatter;
use FI\Statuses\QuoteStatuses;

class Quote extends \Eloquent {

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
   
    public function activities()
    {
        return $this->morphMany('FI\Modules\Activities\Models\Activity', 'audit');
    }

    public function client()
    {
        return $this->belongsTo('FI\Modules\Clients\Models\Client');
    }

    public function custom()
    {
        return $this->hasOne('FI\Modules\CustomFields\Models\QuoteCustom');
    }

    public function amount()
    {
        return $this->hasOne('FI\Modules\Quotes\Models\QuoteAmount');
    }

    public function items()
    {
        return $this->hasMany('FI\Modules\Quotes\Models\QuoteItem')
        ->orderBy('display_order');
    }

    public function taxRates()
    {
        return $this->hasMany('FI\Modules\Quotes\Models\QuoteTaxRate');
    }

    public function user()
    {
        return $this->belongsTo('FI\Modules\Users\Models\User');
    }

    public function group()
    {
        return $this->hasOne('FI\Modules\InvoiceGroups\Models\InvoiceGroup', 'id', 'invoice_group_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
   
    public function getFormattedCreatedAtAttribute()
    {
        return DateFormatter::format($this->attributes['created_at']);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return DateFormatter::format($this->attributes['updated_at']);
    }

    public function getFormattedExpiresAtAttribute($value)
    {
        return DateFormatter::format($this->attributes['expires_at']);
    }

    public function getFormattedTermsAttribute()
    {
        return nl2br($this->attributes['terms']);
    }

    public function getFormattedFooterAttribute()
    {
        return nl2br($this->attributes['footer']);
    }

    public function getStatusTextAttribute()
    {
        $statuses = QuoteStatuses::statuses();

        return $statuses[$this->attributes['quote_status_id']];
    }

    public function getPublicUrlAttribute()
    {
        return route('clientCenter.quote.show', array($this->url_key));
    }

    public function getViewedAttribute()
    {
        return in_array('public.viewed', $this->activities->lists('activity'));
    }

    public function getIsForeignCurrencyAttribute()
    {
        if ($this->attributes['currency_code'] == Config::get('fi.baseCurrency'))
        {
            return false;
        }

        return true;
    }

    public function getCurrencyCodeAttribute()
    {
        return ($this->attributes['currency_code']) ?: $this->client->currency_code;
    }

    public function getTemplateAttribute()
    {
        if ($this->attributes['template'])
        {
            return $this->attributes['template'];
        }
        elseif ($this->client->quote_template)
        {
            return $this->client->quote_template;
        }

        return Config::get('fi.quoteTemplate');
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    public function setExchangeRateAttribute($value)
    {
        if ($this->attributes['currency_code'] == Config::get('fi.baseCurrency'))
        {
            $this->attributes['exchange_rate'] = 1;
        }

        elseif (Config::get('fi.exchangeRateMode') == 'automatic' and !$value)
        {
            $this->attributes['exchange_rate'] = App::make('CurrencyConverter')->convert(Config::get('fi.baseCurrency'), $this->attributes['currency_code']);
        }

        else
        {
            $this->attributes['exchange_rate'] = $value;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeDraft($query)
    {
        return $query->where('quote_status_id', '=', QuoteStatuses::getStatusId('draft'));
    }

    public function scopeSent($query)
    {
        return $query->where('quote_status_id', '=', QuoteStatuses::getStatusId('sent'));
    }

    public function scopeApproved($query)
    {
        return $query->where('quote_status_id', '=', QuoteStatuses::getStatusId('approved'));
    }

    public function scopeRejected($query)
    {
        return $query->where('quote_status_id', '=', QuoteStatuses::getStatusId('rejected'));
    }

    public function scopeCanceled($query)
    {
        return $query->where('quote_status_id', '=', QuoteStatuses::getStatusId('canceled'));
    }

    public function scopeKeywords($query, $keywords)
    {
        $keywords = strtolower($keywords);

        $query->where(DB::raw('lower(number)'), 'like', '%'.$keywords.'%')
        ->orWhere('created_at', 'like', '%'.$keywords.'%')
        ->orWhere('expires_at', 'like', '%'.$keywords.'%')
        ->orWhereIn('client_id', function($query) use($keywords)
        {
            $query->select('id')->from('clients')->where(DB::raw('lower(name)'), 'like', '%'.$keywords.'%');
        });

        return $query;
    }

}