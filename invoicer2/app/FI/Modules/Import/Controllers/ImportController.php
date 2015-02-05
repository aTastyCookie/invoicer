<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Import\Controllers;

use App;
use BaseController;
use Config;
use FI\Modules\Import\Importers\ImportFactory;
use Input;
use Redirect;
use View;

class ImportController extends BaseController {

	/**
	 * Display the initial import screen
	 * @return View
	 */
	public function index()
	{
		$importTypes = array(
			'clients'      => trans('fi.clients'),
			'quotes'       => trans('fi.quotes'),
			'quoteItems'   => trans('fi.quote_items'),
			'invoices'     => trans('fi.invoices'),
			'invoiceItems' => trans('fi.invoice_items'),
			'payments'     => trans('fi.payments'),
			'itemLookups'  => trans('fi.item_lookups')
		);

		return View::make('import.index')
		->with('importTypes', $importTypes);
	}

	/**
	 * Attempt the upload
	 * @return Redirect
	 */
	public function upload()
	{
		$validator = App::make('ImportValidator')->getUploadValidator(Input::all());

		if ($validator->fails())
		{
			return Redirect::route('import.index')
			->withErrors($validator)
			->withInput();
		}

		Input::file('import_file')->move(Config::get('fi.uploadPath'), Input::get('import_type') . '.csv');

		return Redirect::route('import.map', array(Input::get('import_type')));
	}

	/**
	 * Display the screen to map the import fields
	 * @param  string $importType
	 * @return View
	 */
	public function mapImport($importType)
	{
		$importer = ImportFactory::create($importType);

		return View::make('import.map')
		->with('importType', $importType)
		->with('importFields', $importer->getFields($importType))
		->with('fileFields', $importer->getFileFields(Config::get('fi.uploadPath') . '/' . $importType . '.csv'));
	}

	/**
	 * Attempt to import the data
	 * @param  string $importType
	 * @return Redirect
	 */
	public function mapImportSubmit($importType)
	{
		$importer = ImportFactory::create($importType);

		if (!$importer->validateMap(Input::all()))
		{
			return Redirect::route('import.map', array($importType))
			->withErrors($importer->errors())
			->withInput();
		}

		if (!$importer->importData(Input::except('_token')))
		{
			return Redirect::route('import.map', array($importType))
			->withErrors($importer->errors());
		}

		return Redirect::route('import.index')
		->with('alertInfo', trans('fi.records_imported_successfully'));
	}
}