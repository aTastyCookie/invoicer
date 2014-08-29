<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Activities\Models;

use FI\Libraries\DateFormatter;

class Activity extends \Eloquent {

	protected $table = 'activities';
	
	protected $guarded = array('id');

	public function audit()
	{
		return $this->morphTo();
	}

	public function getFormattedActivityAttribute()
	{
		switch ($this->audit_type)
		{
			case 'FI\Modules\Quotes\Models\Quote':

				switch ($this->activity)
				{
					case 'public.viewed':
						return trans('fi.activity_quote_viewed', array('number' => $this->audit->number, 'link' => route('quotes.edit', array($this->audit->id))));
					break;

					case 'public.approved':
						return trans('fi.activity_quote_approved', array('number' => $this->audit->number, 'link' => route('quotes.edit', array($this->audit->id))));
					break;

					case 'public.rejected':
						return trans('fi.activity_quote_rejected', array('number' => $this->audit->number, 'link' => route('quotes.edit', array($this->audit->id))));
					break;
				}

			break;

			case 'FI\Modules\Invoices\Models\Invoice':

				switch ($this->activity)
				{
					case 'public.viewed':
						return trans('fi.activity_invoice_viewed', array('number' => $this->audit->number, 'link' => route('invoices.edit', array($this->audit->id))));
					break;
					case 'public.paid':
						return trans('fi.activity_invoice_paid', array('number' => $this->audit->number, 'link' => route('invoices.edit', array($this->audit->id))));
					break;
				}

			break;
		}
	}

	public function getFormattedCreatedAtAttribute()
	{
		return DateFormatter::format($this->created_at);
	}

}