<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Validators;

use FI\Libraries\NumberFormatter;

use Validator;

class ItemValidator {

	public function getValidator($input)
	{
		$input = (array) $input;

		$input['item_quantity'] = NumberFormatter::unformat($input['item_quantity']);
		$input['item_price']    = NumberFormatter::unformat($input['item_price']);

		$validator = Validator::make($input, array(
			'item_quantity' => 'numeric',
			'item_price'    => 'numeric'
			)
		);

		$validator->sometimes('item_name', 'required', function($input)
		{
			if ($input['item_quantity'] or $input['item_price'])
			{
				return true;
			}
		});

		$validator->sometimes('item_price', 'required', function($input)
		{
			if ($input['item_quantity'] or $input['item_name'])
			{
				return true;
			}
		});

		$validator->sometimes('item_quantity', 'required', function($input)
		{
			if ($input['item_name'] or $input['item_price'])
			{
				return true;
			}
		});

		return $validator;
	}
}