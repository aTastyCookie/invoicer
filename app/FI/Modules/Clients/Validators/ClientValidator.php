<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Clients\Validators;

use Validator;

class ClientValidator {

	public function getValidator($input)
	{
		return Validator::make($input, array(
			'name' => 'required|unique:clients')
		);
	}

	public function getUpdateValidator($input, $id)
	{
		return Validator::make($input, array(
			'name' => 'required|unique:clients,name,' . $id
			)
		);
	}

}