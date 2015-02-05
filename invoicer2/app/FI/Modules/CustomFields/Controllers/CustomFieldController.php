<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\CustomFields\Controllers;

use App;
use BaseController;
use FI\Modules\CustomFields\Libraries\CustomFields;
use Input;
use Redirect;
use View;

class CustomFieldController extends BaseController {

	/**
	 * Custom field repository
	 * @var CustomFieldRepository
	 */
	protected $customField;

	/**
	 * Custom field validator
	 * @var CustomFieldValidator
	 */
	protected $validator;

	public function __construct()
	{
		$this->customField	 = App::make('CustomFieldRepository');
		$this->validator	 = App::make('CustomFieldValidator');
	}

	/**
	 * Display paginated list
	 * @return View
	 */
	public function index()
	{
		$customFields = $this->customField->getPaged();

		return View::make('custom_fields.index')
		->with('customFields', $customFields)
		->with('tableNames', CustomFields::tableNames());
	}

	/**
	 * Display form for new record
	 * @return View
	 */
	public function create()
	{
		return View::make('custom_fields.form')
		->with('editMode', false)
		->with('tableNames', CustomFields::tableNames())
		->with('fieldTypes', CustomFields::fieldTypes());
	}

	/**
	 * Validate and handle new record form submission
	 * @return Redirect
	 */
	public function store()
	{
		$input = Input::all();

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('customFields.create')
			->with('editMode', false)
			->withErrors($validator)
			->withInput();
		}

		$input['column_name'] = $this->customField->getNextColumnName($input['table_name']);

		$this->customField->create($input);

		$this->customField->createCustomColumn($input['table_name'], $input['column_name'], $input['field_type']);

		return Redirect::route('customFields.index')
		->with('alertSuccess', trans('fi.record_successfully_created'));
	}

	/**
	 * Display form for existing record
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$customField = $this->customField->find($id);

		return View::make('custom_fields.form')
		->with('editMode', true)
		->with('customField', $customField)
		->with('tableNames', CustomFields::tableNames())
		->with('fieldTypes', CustomFields::fieldTypes());
	}

	/**
	 * Validate and handle existing record form submission
	 * @param  int $id
	 * @return Redirect
	 */
	public function update($id)
	{
		$input = Input::all();

		unset($input['table_name']);

		$validator = $this->validator->getUpdateValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('customFields.edit', array($id))
			->with('editMode', true)
			->withErrors($validator)
			->withInput();
		}

		$this->customField->update($input, $id);

		return Redirect::route('customFields.index')
		->with('alertInfo', trans('fi.record_successfully_updated'));
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return Redirect
	 */
	public function delete($id)
	{
		$customField = $this->customField->find($id);

		$this->customField->deleteCustomColumn($customField->table_name, $customField->column_name);

		$this->customField->delete($id);

		return Redirect::route('customFields.index')
		->with('alert', trans('fi.record_successfully_deleted'));
	}

}
