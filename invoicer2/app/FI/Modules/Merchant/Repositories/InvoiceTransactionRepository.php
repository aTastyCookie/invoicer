<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Repositories;

use FI\Libraries\BaseRepository;
use FI\Modules\Merchant\Models\InvoiceTransaction;

class InvoiceTransactionRepository extends BaseRepository {

	public function __construct(InvoiceTransaction $model)
	{
		$this->model = $model;
	}

}