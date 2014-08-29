<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Settings\Repositories;

use Config;
use FI\Libraries\DateFormatter;
use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\QueryException;
use PDOException;

class SettingRepository {

	/**
	 * Used during app start to place settings in Config
	 * @return void
	 */
	public function setAll()
	{
		try 
		{
			$settings = Setting::all();

			foreach ($settings as $setting)
			{
				Config::set('fi.' . $setting->setting_key, $setting->setting_value);
			}

			return true;

		}
		catch (QueryException $e)
		{
			return false;
		}
		catch (PDOException $e)
		{
			return false;
		}
	}

	/**
	 * Saves settings submitted by the setting form
	 * @param  string $key
	 * @param  string $value
	 * @return void
	 */
	public function save($key, $value)
	{
		if ($setting = Setting::where('setting_key', $key)->first())
		{
			$setting->setting_value = $value;
			$setting->save();
		}
		else
		{
			Setting::create(array('setting_key' => $key, 'setting_value' => $value));
		}
	}

	/**
	 * Delete a setting by key
	 * @param  string $key
	 * @return void
	 */
	public function delete($key)
	{
		Setting::where('setting_key', $key)->delete();
	}

}