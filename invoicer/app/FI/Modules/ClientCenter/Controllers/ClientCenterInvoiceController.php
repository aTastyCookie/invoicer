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

use Config;
use Event;
use FI\Libraries\HTML;
use FI\Libraries\PDF;
use FI\Statuses\InvoiceStatuses;
use View;

class ClientCenterInvoiceController extends \BaseController {

	public function __construct($invoice)
	{
		$this->invoice = $invoice;
	}

	public function show($urlKey)
	{
		$invoice = $this->invoice->findByUrlKey($urlKey);

		$merchantIsRedirect = false;

		if (Config::get('payments.enabled'))
		{
			$merchant = Config::get('payments.default');

			$merchantLib = '\\FI\\Modules\\Merchant\\Libraries\\' . $merchant;

			$merchantIsRedirect = $merchantLib::isRedirect();
		}

		Event::fire('invoice.public.viewed', $invoice);

		return View::make('client_center.invoice')
		->with('invoice', $invoice)
		->with('statuses', InvoiceStatuses::statuses())
		->with('merchantIsRedirect', $merchantIsRedirect)
		->with('urlKey', $urlKey);
	}

	public function pdf($urlKey)
	{
		$invoice = $this->invoice->findByUrlKey($urlKey);

		$html = HTML::invoice($invoice);

		$pdf = new PDF($html);

		$pdf->download(trans('fi.invoice') . '_' . $invoice->number . '.pdf');
	}

	public function html($urlKey)
	{
		$invoice = $this->invoice->findByUrlKey($urlKey);

		return HTML::invoice($invoice);
	}
}