<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\ItemLookups\Controllers;

use Input;
use Redirect;
use View;

use FI\Libraries\NumberFormatter;

class ItemLookupController extends \BaseController {

	/**
	 * Item lookup repository
	 * @var ItemLookupRepository
	 */
	protected $itemLookup;

	/**
	 * Item lookup validator
	 * @var ItemLookupValidator
	 */
	protected $validator;

	/**
	 * Dependency injection
	 * @param ItemLookupRepository $itemLookup
	 * @param ItemLookupValidator $validator
	 */
	public function __construct($itemLookup, $validator)
	{
		$this->itemLookup = $itemLookup;
		$this->validator = $validator;
	}

	/**
	 * Display paginated list
	 * @return View
	 */
	public function index()
	{
		$itemLookups = $this->itemLookup->getPaged();

		return View::make('item_lookups.index')
		->with('itemLookups', $itemLookups);
	}

	/**
	 * Display form for new record
	 * @return View
	 */
	public function create()
	{
		return View::make('item_lookups.form')
		->with('editMode', false);
	}

	/**
	 * Validate and handle new record form submission
	 * @return RedirectResponse
	 */
	public function store()
	{
		$input = Input::all();

		$input['price'] = NumberFormatter::unformat($input['price']);

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('itemLookups.create')
			->with('editMode', false)
			->withErrors($validator)
			->withInput();
		}
        
		$this->itemLookup->create($input);
		
		return Redirect::route('itemLookups.index')
		->with('alertSuccess', trans('fi.record_successfully_created'));
	}

	/**
	 * Display form for existing record
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$itemLookup = $this->itemLookup->find($id);
		
		return View::make('item_lookups.form')
		->with(array('editMode' => true, 'itemLookup' => $itemLookup));
	}

	/**
	 * Validate and handle existing record form submission
	 * @param  int $id
	 * @return RedirectResponse
	 */
	public function update($id)
	{
		$input = Input::all();

		$input['price'] = NumberFormatter::unformat($input['price']);

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('itemLookups.edit', array($id))
			->with('editMode', true)
			->withErrors($validator)
			->withInput();
		}
        
		$this->itemLookup->update($input, $id);

		return Redirect::route('itemLookups.index')
		->with('alertInfo', trans('fi.record_successfully_updated'));
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return RedirectResponse
	 */
	public function delete($id)
	{
		$this->itemLookup->delete($id);

		return Redirect::route('itemLookups.index')
		->with('alert', trans('fi.record_successfully_deleted'));
	}
    
	/**
	 * Return a json list of records matching the provided query
	 * @return json
	 */
	public function ajaxItemLookup()
	{
		return $this->itemLookup->lookup(Input::get('query'));
	}

}