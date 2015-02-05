<?php

namespace FI\Modules\Invoices\Composers;

use Config;
use FI\Statuses\InvoiceStatuses;

class InvoiceTableComposer {

	public function compose($view)
	{
		$view->with('statuses', InvoiceStatuses::statuses());
	}

}