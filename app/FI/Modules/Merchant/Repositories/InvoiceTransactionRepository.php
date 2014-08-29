<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Repositories;

use FI\Modules\Merchant\Models\InvoiceTransaction;

class InvoiceTransactionRepository extends \FI\Libraries\BaseRepository {

	public function __construct(InvoiceTransaction $model)
	{
		$this->model = $model;
	}

}