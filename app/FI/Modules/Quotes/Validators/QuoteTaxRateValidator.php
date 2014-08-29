<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Validators;

use Validator;

class QuoteTaxRateValidator {

	public function getValidator($input)
	{
		return Validator::make($input, array(
			'tax_rate_id'         => 'required|numeric|min:1',
			'include_item_tax'    => 'required'
			)
		);
	}
}