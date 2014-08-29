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

use App;
use Config;

class NumberFormatter {

	/**
	 * Formats a number accordingly
	 * @param  float $number
	 * @param  string $currencyCode
	 * @return float
	 */
	public static function format($number, $currencyCode = null)
	{
		$currency = App::make('CurrencyRepository')->findByCode(($currencyCode) ?: Config::get('fi.baseCurrency'));

		return number_format($number, 2, $currency->decimal, $currency->thousands);
	}

	/**
	 * Unformats a formatted number
	 * @param  float $number
	 * @param  string $currencyCode
	 * @return float
	 */
	public static function unformat($number, $currencyCode = null)
	{
		$currency = App::make('CurrencyRepository')->findByCode(($currencyCode) ?: Config::get('fi.baseCurrency'));

		$number = str_replace($currency->decimal, 'D', $number);
		$number = str_replace($currency->thousands, '', $number);
		$number = str_replace('D', '.', $number);

		return $number;
	}

}