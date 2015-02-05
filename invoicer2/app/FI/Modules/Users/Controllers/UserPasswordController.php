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

use App;
use BaseController;
use FI\Libraries\BackPath;
use Hash;
use Input;
use Redirect;
use View;

class UserPasswordController extends BaseController {

	/**
	 * User Repository
	 * @var UserRepository
	 */
	protected $user;

	/**
	 * User Validator
	 * @var UserValidator
	 */
	protected $validator;

	public function __construct()
	{
		$this->user      = App::make('UserRepository');
		$this->validator = App::make('UserValidator');
	}

	/**
	 * Display the form to change password
	 * @param  int $userId
	 * @return View
	 */
	public function edit($userId)
	{
		return View::make('users.password_form')
		->with('user', $this->user->find($userId));
	}

	/**
	 * Attempt to change the password
	 * @param  int $userId
	 * @return Redirect
	 */
	public function update($userId)
	{
		$validator = $this->validator->getUpdatePasswordValidator(Input::all());

		if ($validator->fails())
		{
			return Redirect::route('users.password.edit', array($userId))
			->withErrors($validator);
		}

		$this->user->updatePassword(Hash::make(Input::get('password')), $userId);

		return Redirect::to(BackPath::getBackPath('users'))
		->with('alertInfo', trans('fi.password_successfully_reset'));
	}

}