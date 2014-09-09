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

class Logo {

	public static function getImg($width = 75)
	{
		if (Config::get('fi.logo') and file_exists(Config::get('fi.uploadPath') . '/' . Config::get('fi.logo')))
		{
			$logo = base64_encode(file_get_contents(Config::get('fi.uploadPath') . '/' . Config::get('fi.logo')));

			return '<img src="data:image/png;base64,' . $logo . '" style="width: ' . $width . 'px;">';
		}

		return null;
	}

	public static function delete()
	{
		if (file_exists(Config::get('fi.uploadPath') . '/' . Config::get('fi.logo')))
		{
			unlink(Config::get('fi.uploadPath') . '/' . Config::get('fi.logo'));
		}
	}

}