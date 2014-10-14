<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries;

use Config;
use View;

class HTML {

	public static function invoice($invoice)
	{
        Config::set('fi.baseCurrency', $invoice->currency_code);

		return View::make('templates.invoices.' . str_replace('.blade.php', '', $invoice->template))
		->with('invoice', $invoice)
        ->with('logo', Logo::getImg())->render();
	}

	public static function quote($quote)
	{
        Config::set('fi.baseCurrency', $quote->currency_code);

		return View::make('templates.quotes.' . str_replace('.blade.php', '', $quote->template))
		->with('quote', $quote)
        ->with('logo', Logo::getImg())->render();
	}

}