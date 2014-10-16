<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Users\Controllers;

use FI\Libraries\CustomFields;
use Hash;
use Input;
use Redirect;
use View;

class UserController extends \BaseController {

	/**
	 * Custom field repository
	 * @var CustomFieldRepository
	 */
	protected $customField;

	/**
	 * The user repository
	 * @var UserRepository
	 */
	protected $user;

	/**
	 * User custom repository
	 * @var UserCustomRepository
	 */
	protected $userCustom;

	/**
	 * The user validator
	 * @var UserValidator
	 */
	protected $validator;

	/**
	 * Dependency injection
	 * @param UserRepository $user
	 * @param UserValidator $validator
	 */
	public function __construct($customField, $user, $userCustom, $validator)
	{
		$this->customField = $customField;
		$this->user        = $user;
		$this->userCustom  = $userCustom;
		$this->validator   = $validator;
	}

	/**
	 * Display paginated list
	 * @return View
	 */
	public function index()
	{
		$users = $this->user->getPaged();

		return View::make('users.index')
		->with('users', $users);
	}

	/**
	 * Display form for new record
	 * @return View
	 */
	public function create()
	{
		return View::make('users.form')
		->with('editMode', false)
		->with('customFields', $this->customField->getByTable('users'));
	}

	/**
	 * Validate and handle new record form submission
	 * @return RedirectResponse
	 */
	public function store()
	{
		$input = Input::all();

		if (Input::has('custom'))
		{
			$custom = $input['custom'];
			unset($input['custom']);
		}

		$validator = $this->validator->getValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('users.create')
			->with('editMode', false)
			->withErrors($validator)
			->withInput();
		}

		unset($input['password_confirmation']);

		$input['password'] = Hash::make($input['password']);

		$userId = $this->user->create($input)->id;

		if (Input::has('custom'))
		{
			$this->userCustom->save($custom, $userId);
		}
	
		return Redirect::route('users.index')
		->with('alertSuccess', trans('fi.record_successfully_created'));
	}

	/**
	 * Display form for existing record
	 * @param  int $id
	 * @return View
	 */
	public function edit($id)
	{
		$user = $this->user->find($id);
		
		return View::make('users.form')
		->with(array('editMode' => true, 'user' => $user))
		->with('customFields', $this->customField->getByTable('users'));
	}

	/**
	 * Validate and handle existing record form submission
	 * @param  int $id
	 * @return RedirectResponse
	 */
	public function update($id)
	{
		$input = Input::all();

		if (Input::has('custom'))
		{
			$custom = $input['custom'];
			unset($input['custom']);
		}

		$validator = $this->validator->getUpdateValidator($input);

		if ($validator->fails())
		{
			return Redirect::route('users.edit', array($id))
			->with('editMode', true)
			->withErrors($validator)
			->withInput();
		}

		$this->user->update($input, $id);

		if (Input::has('custom'))
		{
			$this->userCustom->save($custom, $id);
		}

		return Redirect::route('users.index')
		->with('alertInfo', trans('fi.record_successfully_updated'));
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return RedirectResponse
	 */
	public function delete($id)
	{
		$this->user->delete($id);

		return Redirect::route('users.index')
		->with('alert', trans('fi.record_successfully_deleted'));
	}

}