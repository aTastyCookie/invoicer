<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Settings\Controllers;

use App;
use Config;
use Crypt;
use FI\Libraries\DateFormatter;
use FI\Libraries\Email;
use FI\Libraries\Languages;
use FI\Libraries\Logo;
use FI\Libraries\InvoiceTemplates;
use FI\Libraries\QuoteTemplates;
use FI\Modules\Settings\Libraries\UpdateChecker;
use Input;
use Redirect;
use Response;
use View;

class SettingController extends \BaseController {

	/**
	 * Setting repository
	 * @var SettingRepository
	 */
	protected $settings;

	/**
	 * Dependency injection
	 * @param SettingRepository $settings
	 */
	public function __construct($settings)
	{
		$this->settings       = $settings;
	}
	
	/**
	 * Displays the settings
	 * @return View
	 */
	public function index()
	{
		return View::make('settings.index')
		->with(array(
			'languages'         => Languages::listLanguages(),
			'dateFormats'       => DateFormatter::dropdownArray(),
			'invoiceTemplates'  => InvoiceTemplates::lists(),
			'quoteTemplates'    => QuoteTemplates::lists(),
			'invoiceGroups'     => App::make('InvoiceGroupRepository')->lists(),
			'taxRates'          => App::make('TaxRateRepository')->lists(),
			'paymentMethods'    => App::make('PaymentMethodRepository')->lists(),
			'emailSendMethods'  => Email::listSendMethods(),
			'emailEncryptions'  => Email::listEncryptions(),
			'yesNoArray'        => array('0' => trans('fi.no'), '1' => trans('fi.yes')),
			'timezones'         => array_combine(timezone_identifiers_list(), timezone_identifiers_list()),
			'invoiceLogoImg'    => Logo::getImg(),
			'includeItemTax'    => array('0' => trans('fi.apply_before_item_tax'), '1' => trans('fi.apply_after_item_tax')),
			'paperSizes'        => array('letter' => trans('fi.letter'), 'A4'=> trans('fi.a4'), 'legal' => trans('fi.legal')),
			'paperOrientations' => array('portrait' => trans('fi.portrait'), 'landscape' => trans('fi.landscape')),
			'currencies'        => App::make('CurrencyRepository')->lists(),
			'exchangeRateModes' => array('automatic' => trans('fi.automatic'), 'manual' => trans('fi.manual'))
		));
	}

	/**
	 * Handle setting form submission
	 * @return Redirect
	 */
	public function update()
	{
		foreach (Input::all() as $key => $value)
		{
			if (substr($key, 0, 8) == 'setting_')
			{
				$skipSave = false;
				
				$key = substr($key, 8);

				if ($key == 'mailPassword' and $value)
				{
					$value = Crypt::encrypt($value);
				}
				elseif ($key == 'mailPassword' and !$value)
				{
					$skipSave = true;
				}

				if (!$skipSave)
				{
					$this->settings->save($key, $value);
				}
			}
		}

		if (Input::hasFile('logo'))
		{
			$ext = Input::file('logo')->getClientOriginalExtension();

			Input::file('logo')->move(Config::get('fi.uploadPath'), 'logo.' . $ext);

			$this->settings->save('logo', 'logo.' . $ext);
		}

		return Redirect::route('settings.index')
		->with('alertSuccess', trans('fi.settings_successfully_saved'));
	}

	/**
	 * Deletes logo
	 * @return Redirect
	 */
	public function logoDelete()
	{
		Logo::delete();
		
		$this->settings->delete('logo');

		return Redirect::route('settings.index');
	}

	public function updateCheck()
	{
		$updateChecker = new UpdateChecker;

		$updateAvailable = $updateChecker->updateAvailable();
		$currentVersion  = $updateChecker->getCurrentVersion();

		if ($updateAvailable)
		{
			$message = trans('fi.update_available', array('version' => $currentVersion));
		}
		else
		{
			$message = trans('fi.update_not_available');
		}

		return Response::json(
			array(
				'success' => true,
				'message' => $message
			), 200
		);
	}

}