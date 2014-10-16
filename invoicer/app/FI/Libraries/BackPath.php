<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries;

use Session;
use URL;

class BackPath {

	/**
	 * Sets a path to redirect back to where applicable
	 */
	public static function setBackPath()
	{
		$exclude = "/(create|edit|update|store|delete|ajax|modal|mail|quote_to_invoice|pdf)/";

		$path = trim(str_replace(URL::to('/'), '', URL::full()), '/');

		if (!preg_match($exclude, $path))
		{
			Session::set('backPath', $path);
		}
	}

	/**
	 * Retrieves the redirect back path
	 * @param  string $default
	 * @return string
	 */
	public static function getBackPath($default = null)
	{
		return (Session::get('backPath')) ?: $default;
	}
}