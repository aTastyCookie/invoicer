<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\InvoiceGroups\Validators;

use Validator;

class InvoiceGroupValidator {

	public function getValidator($input)
	{
		return Validator::make($input, array(
			'name'     => 'required',
			'next_id'  => 'required|integer',
			'left_pad' => 'required|numeric'
		));
	}

}