<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\ClientCenter\Controllers;

use Config;
use Event;
use FI\Libraries\HTML;
use FI\Libraries\PDF;
use FI\Statuses\QuoteStatuses;
use Redirect;
use View;

class ClientCenterQuoteController extends \BaseController {

	public function __construct($quote)
	{
		$this->quote = $quote;
	}

	public function show($urlKey)
	{
		$quote = $this->quote->findByUrlKey($urlKey);

		Event::fire('quote.public.viewed', $quote);

		return View::make('client_center.quote')
		->with('quote', $quote)
		->with('statuses', quoteStatuses::statuses())
		->with('urlKey', $urlKey);
	}

	public function pdf($urlKey)
	{
		$quote = $this->quote->findByUrlKey($urlKey);

		$html = HTML::quote($quote);

		$pdf = new PDF($html);

		$pdf->download(trans('fi.quote') . '_' . $quote->number . '.pdf');
	}

	public function html($urlKey)
	{
		$quote = $this->quote->findByUrlKey($urlKey);

		return HTML::quote($quote);
	}

	public function approve($urlKey)
	{
		$quote = $this->quote->approve($urlKey);

		Event::fire('quote.approved', $quote);

		return Redirect::route('clientCenter.quote.show', array($urlKey));
	}

	public function reject($urlKey)
	{
		$quote = $this->quote->reject($urlKey);

		Event::fire('quote.rejected', $quote);

		return Redirect::route('clientCenter.quote.show', array($urlKey));
	}
}