<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\ClientCenter\Controllers;

use App;
use BaseController;
use Config;
use Event;
use FI\Libraries\PDF\PDFFactory;
use FI\Statuses\QuoteStatuses;
use Redirect;
use View;

class ClientCenterQuoteController extends BaseController {

	public function __construct()
	{
		$this->quote = App::make('QuoteRepository');
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

		$pdf = PDFFactory::create();

		$pdf->download($quote->html, trans('fi.quote') . '_' . $quote->number . '.pdf');
	}

	public function html($urlKey)
	{
		$quote = $this->quote->findByUrlKey($urlKey);

		return $quote->html;
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