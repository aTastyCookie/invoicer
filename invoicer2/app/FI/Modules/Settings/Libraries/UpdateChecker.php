<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Settings\Libraries;

use Config;

class UpdateChecker {

	protected $currentVersion;

	public function __construct()
	{
		$this->currentVersion = file_get_contents('https://www.HubPay.com/current-version');
	}

	/**
	 * Check to see if there is a newer version available for download
	 * @return boolean
	 */
	public function updateAvailable()
	{
		if ($this->currentVersion > Config::get('fi.version'))
		{
			return true;
		}

		return false;
	}

	/**
	 * Getter for current version
	 * @return string
	 */
	public function getCurrentVersion()
	{
		return $this->currentVersion;
	}

}