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
use FI\Statuses\InvoiceStatuses;
use View;

class ClientCenterInvoiceController extends BaseController {

    public function __construct()
    {
        $this->invoice = App::make('InvoiceRepository');
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

        $pdf = PDFFactory::create();

        $pdf->download($invoice->html, trans('fi.invoice') . '_' . $invoice->number . '.pdf');
    }

    public function html($urlKey)
    {
        $invoice = $this->invoice->findByUrlKey($urlKey);

        return $invoice->html;
    }
}