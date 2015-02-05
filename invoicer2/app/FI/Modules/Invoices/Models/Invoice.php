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

use App;
use Config;
use DB;
use Eloquent;
use FI\Libraries\CurrencyFormatter;
use FI\Libraries\DateFormatter;
use FI\Libraries\HTML;
use FI\Statuses\InvoiceStatuses;

class Invoice extends Eloquent {

    /**
     * Guarded properties
     * @var array
     */
    protected $guarded = array('id');

    public static function boot()
    {
        parent::boot();

        static::saving(function($invoice)
        {
            if ($invoice->template == Config::get('fi.invoiceTemplate'))
            {
                $invoice->template = null;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function activities()
    {
        return $this->morphMany('FI\Modules\Activities\Models\Activity', 'audit');
    }

    public function amount()
    {
        return $this->hasOne('FI\Modules\Invoices\Models\InvoiceAmount');
    }

    public function client()
    {
        return $this->belongsTo('FI\Modules\Clients\Models\Client');
    }

    public function custom()
    {
        return $this->hasOne('FI\Modules\CustomFields\Models\InvoiceCustom');
    }

    public function items()
    {
        return $this->hasMany('FI\Modules\Invoices\Models\InvoiceItem')
            ->orderBy('display_order');
    }

    public function payments()
    {
        return $this->hasMany('FI\Modules\Payments\Models\Payment');
    }

    public function taxRates()
    {
        return $this->hasMany('FI\Modules\Invoices\Models\InvoiceTaxRate');
    }

    public function user()
    {
        return $this->belongsTo('FI\Modules\Users\Models\User');
    }

    public function group()
    {
        return $this->hasOne('FI\Modules\InvoiceGroups\Models\InvoiceGroup', 'id', 'invoice_group_id');
    }

    public function recurring()
    {
        return $this->hasMany('FI\Modules\Invoices\Models\RecurringInvoice');
    }

    public function transactions()
    {
        return $this->hasMany('FI\Modules\Merchant\Models\InvoiceTransaction');
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

    public function getFormattedDueAtAttribute()
    {
        return DateFormatter::format($this->attributes['due_at']);
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
        $statuses = InvoiceStatuses::statuses();

        return $statuses[$this->attributes['invoice_status_id']];
    }

    public function getIsOverdueAttribute()
    {
        // Only invoices in Sent status qualify to be overdue
        if ($this->attributes['due_at'] < date('Y-m-d') and $this->attributes['invoice_status_id'] == InvoiceStatuses::getStatusId('sent'))
            return 1;

        return 0;
    }

    public function getPublicUrlAttribute()
    {
        return route('clientCenter.invoice.show', array($this->url_key));
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

    public function getTemplateAttribute($value)
    {
        if ($value)
        {
            return $value;
        }
        elseif ($this->client->invoice_template)
        {
            return $this->client->invoice_template;
        }

        return Config::get('fi.invoiceTemplate');
    }

    public function getHtmlAttribute()
    {
        return HTML::invoice($this);
    }

    /**
     * Gathers a summary of both invoice and item taxes to be displayed on invoice
     * @return array
     */
    public function getSummarizedTaxesAttribute()
    {
        $taxes = array();

        foreach ($this->taxRates as $taxRate)
        {
            $key = $taxRate->taxRate->name;

            if (!isset($taxes[$key]))
            {
                $taxes[$key]              = new \stdClass();
                $taxes[$key]->name        = $taxRate->taxRate->name;
                $taxes[$key]->percent     = $taxRate->taxRate->formatted_percent;
                $taxes[$key]->total       = $taxRate->tax_total;
                $taxes[$key]->raw_percent = $taxRate->taxRate->percent;
            }
            else
            {
                $taxes[$key]->total += $taxRate->tax_total;
            }
        }

        foreach ($this->items as $item)
        {
            if ($item->taxRate)
            {
                $key = $item->taxRate->name;

                if (!isset($taxes[$key]))
                {
                    $taxes[$key]              = new \stdClass();
                    $taxes[$key]->name        = $item->taxRate->name;
                    $taxes[$key]->percent     = $item->taxRate->formatted_percent;
                    $taxes[$key]->total       = $item->amount->tax_total;
                    $taxes[$key]->raw_percent = $item->taxRate->percent;
                }
                else
                {
                    $taxes[$key]->total += $item->amount->tax_total;
                }
            }
        }

        foreach ($taxes as $key => $tax)
        {
            $taxes[$key]->total = CurrencyFormatter::format($tax->total, $this->currency_code);
        }

        return $taxes;
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
        return $query->where('invoice_status_id', '=', InvoiceStatuses::getStatusId('draft'));
    }

    public function scopeSent($query)
    {
        return $query->where('invoice_status_id', '=', InvoiceStatuses::getStatusId('sent'));
    }

    public function scopePaid($query)
    {
        return $query->where('invoice_status_id', '=', InvoiceStatuses::getStatusId('paid'));
    }

    public function scopeCanceled($query)
    {
        return $query->where('invoice_status_id', '=', InvoiceStatuses::getStatusId('canceled'));
    }

    public function scopeStatusIn($query, $statuses)
    {
        $statusCodes = array();

        foreach ($statuses as $status)
        {
            $statusCodes[] = InvoiceStatuses::getStatusId($status);
        }

        return $query->whereIn('invoice_status_id', $statusCodes);
    }

    public function scopeOverdue($query)
    {
        // Only invoices in Sent status qualify to be overdue
        return $query
            ->where('invoice_status_id', '=', InvoiceStatuses::getStatusId('sent'))
            ->where('due_at', '<', date('Y-m-d'));
    }

    public function scopeKeywords($query, $keywords)
    {
        $keywords = strtolower($keywords);

        $query->where(DB::raw('lower(number)'), 'like', '%' . $keywords . '%')
            ->orWhere('created_at', 'like', '%' . $keywords . '%')
            ->orWhere('due_at', 'like', '%' . $keywords . '%')
            ->orWhereIn('client_id', function ($query) use ($keywords)
            {
                $query->select('id')->from('clients')->where(DB::raw('lower(name)'), 'like', '%' . $keywords . '%');
            });

        return $query;
    }
}