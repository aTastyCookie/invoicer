<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Sessions\Controllers;

use Auth;
use Input;
use Redirect;
use View;

class SessionController extends \BaseController {

	/**
	 * Session validator
	 * @var SessionValidator
	 */
	protected $validator;

	/**
	 * Dependency injection
	 * @param SessionValidator $validator
	 */
	public function __construct($validator)
	{
		$this->validator = $validator;
	}
	
	/**
	 * Display the login form
	 * @return View
	 */
	public function login()
	{
		return View::make('sessions.login');
	}

	/**
	 * Attempt to authenticate the user
	 * @return Redirect
	 */
	public function attempt()
	{
		$validator = $this->validator->getValidator(Input::all());

		if ($validator->fails())
		{
			return Redirect::route('session.login')->withErrors($validator);
		}

		if (!Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
		{
			return Redirect::route('session.login')->with('errors', array(trans('fi.invalid_login')));
		}

		return Redirect::route('dashboard.index');
	}

	/**
	 * Log the user out
	 * @return Redirect
	 */
	public function logout()
	{
		Auth::logout();

		return Redirect::route('session.login');
	}

}