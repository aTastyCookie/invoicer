<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Validators;

use Validator;

class QuoteValidator {

	public function getValidator($input)
	{
		return Validator::make($input, array(
			'created_at'       => 'required',
			'client_name'      => 'required',
			'invoice_group_id' => 'required'
			)
		);
	}

	public function getUpdateValidator($input)
	{
		return Validator::make($input, array(
			'created_at'      => 'required',
			'expires_at'      => 'required',
			'number'          => 'required',
			'quote_status_id' => 'required',
			'exchange_rate'   => 'required|numeric'
			)
		);
	}

	public function getToInvoiceValidator($input)
	{
		return Validator::make($input, array(
			'client_id'        => 'required',
			'created_at'       => 'required',
			'invoice_group_id' => 'required'
			)
		);
	}

	public function getRawValidator($input)
	{
		return Validator::make($input, array(
			'created_at'       => 'required|date',
			'user_id'          => 'required|integer',
			'client_id'        => 'required|integer',
			'invoice_group_id' => 'required|integer',
			'quote_status_id'  => 'required|integer',
			'expires_at'       => 'required|date',
			'number'           => 'required'
			)
		);
	}
}