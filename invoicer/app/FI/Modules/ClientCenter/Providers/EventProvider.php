<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\ClientCenter\Providers;

use App;
use Auth;
use Config;
use Event;
use FI\Libraries\DateFormatter;
use Illuminate\Support\ServiceProvider;
use Mail;

class EventProvider extends ServiceProvider {

	/**
	 * Register the service provider
	 * @return void
	 */
	public function register() {}

	/**
	 * Bootstrap the application events
	 * @return void
	 */
	public function boot()
	{
		Event::listen('quote.public.viewed', function($quote)
		{
			// Track this activity only when the user is not authenticated
			if (!Auth::check())
			{
				$quote->activities()->create(array('activity' => 'public.viewed'));
			}
		});

		Event::listen('invoice.public.viewed', function($invoice)
		{
			// Track this activity only when the user is not authenticated
			if (!Auth::check())
			{
				$invoice->activities()->create(array('activity' => 'public.viewed'));
			}
		});

		Event::listen('quote.approved', function($quote)
		{
			// Create the activity record
			$quote->activities()->create(array('activity' => 'public.approved'));

			// If applicable, convert the quote to an invoice when quote is approved
			if (Config::get('fi.convertQuoteWhenApproved'))
			{
				App::make('QuoteInvoiceRepository')->quoteToInvoice(
					$quote,
					date('Y-m-d'),
					DateFormatter::incrementDateByDays(date('Y-m-d'), Config::get('fi.invoicesDueAfter')),
					Config::get('fi.invoiceGroup')
				);
			}
		});

		Event::listen('quote.rejected', function($quote)
		{
			// Create the activity record
			$quote->activities()->create(array('activity' => 'public.rejected'));
		});
	}
}