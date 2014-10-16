<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Validators;

use Validator;

class InvoiceValidator {

    public function getValidator($input)
    {
        return Validator::make($input,
            array(
                'created_at'          => 'required',
                'client_name'         => 'required',
                'invoice_group_id'    => 'required',
                'recurring_frequency' => 'required_if:recurring,1',
                'recurring_period'    => 'required_if:recurring,1'
            )
        );
    }

    public function getUpdateValidator($input)
    {
        return Validator::make($input,
            array(
                'created_at'        => 'required',
                'due_at'            => 'required',
                'number'            => 'required',
                'invoice_status_id' => 'required',
                'exchange_rate'     => 'required|numeric',
                'template'          => 'required'
            )
        );
    }

    public function getRawValidator($input)
    {
        return Validator::make($input,
            array(
                'created_at'        => 'required|date',
                'user_id'           => 'required|integer',
                'client_id'         => 'required|integer',
                'invoice_group_id'  => 'required|integer',
                'invoice_status_id' => 'required|integer',
                'due_at'            => 'required|date',
                'number'            => 'required'
            )
        );
    }
}