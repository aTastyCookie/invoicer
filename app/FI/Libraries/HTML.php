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
use FI\Libraries\Logo;
use View;

class HTML {

	public static function invoice($invoice)
	{
		return View::make('templates.invoices.' . str_replace('.blade.php', '', Config::get('fi.invoiceTemplate')))
		->with('invoice', $invoice)
		->with('logo', function($width) { return Logo::getImg($width); });
	}

	public static function quote($quote)
	{
		return View::make('templates.quotes.' . str_replace('.blade.php', '', Config::get('fi.quoteTemplate')))
		->with('quote', $quote)
		->with('logo', function($width) { return Logo::getImg($width); });
	}

}