<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Currencies\Controllers;

use Config;
use Input;
use Redirect;
use View;

use FI\Libraries\NumberFormatter;

class CurrencyController extends \BaseController {
	
	/**
	 * Tax rate repository
	 * @var CurrencyRepository
	 */
	protected $currency;

	/**
	 * Tax rate validator
	 * @var CurrencyValidator
	 */
	protected $validator;
	
	/**
	 * Dependency injection
	 * @param CurrencyRepository $currency
	 * @param CurrencyValidator $validator
	 */
	public function __construct($currency, $validator)
	{
		$this->currency = $currency;
		$this->validator = $validator;
	}

	/**
	 * Display paginated list
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$currencies = $this->currency->getPaged();

		return View::make('currencies.index')
		->with('currencies', $currencies)
		->with('baseCurrency', Config::get('fi.baseCurrency'));
	}

	/**
	 * Display form for new record
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return View::make('currencies.form')
		->with('editMode', false);
	}

	/**
	 * Validate and handle new record form submission
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		$input = Input::all();

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('currencies.create')
			->with('editMode', false)
			->withErrors($validator)
			->withInput();
		}

		$this->currency->create($input);
		
		return Redirect::route('currencies.index')
		->with('alertSuccess', trans('fi.record_successfully_created'));
	}

	/**
	 * Display form for existing record
	 * @param  int $id
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$currency = $this->currency->find($id);
		
		return View::make('currencies.form')
		->with(array('editMode' => true, 'currency' => $currency, 'currencyInUse' => $this->currency->currencyInUse($id)));
	}

	/**
	 * Validate and handle existing record form submission
	 * @param  int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		$input = Input::all();

		$validator = $this->validator->getUpdateValidator($input, $id);

		if ($validator->fails())
		{
			return Redirect::route('currencies.edit', array($id))
			->with('editMode', true)
			->withErrors($validator)
			->withInput();
		}

		$this->currency->update($input, $id);

		return Redirect::route('currencies.index')
		->with('alertInfo', trans('fi.record_successfully_updated'));
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$alert = $this->currency->delete($id);

		return Redirect::route('currencies.index')
		->with('alert', $alert);
	}

}