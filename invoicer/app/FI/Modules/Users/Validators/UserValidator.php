<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Users\Validators;

use Validator;

class UserValidator {

	public function getValidator($input)
	{
		return Validator::make($input, array(
			'email'    => 'required|email',
			'password' => 'required|confirmed',
			'name'     => 'required'
			)
		);
	}

	public function getUpdateValidator($input)
	{
		return Validator::make($input, array(
			'email'    => 'required|email',
			'name'     => 'required'
			)
		);
	}

	public function getUpdatePasswordValidator($input)
	{
		return Validator::make($input, array(
			'password' => 'required|confirmed'
			)
		);
	}
}