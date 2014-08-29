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

class CurrencyFormatter extends NumberFormatter {
	
	/**
	 * Formats currency according to FI config
	 * @param  float $amount
	 * @param  string $currencyCode
	 * @return string
	 */
	public static function format($amount, $currencyCode = null)
	{
		$amount = parent::format($amount, $currencyCode);

		$currency = App::make('CurrencyRepository')->findByCode(($currencyCode) ?: Config::get('fi.baseCurrency'));

		if ($currency->placement == 'before')
		{
			return $currency->symbol . $amount;
		}

		return $amount . $currency->symbol;
	}
}