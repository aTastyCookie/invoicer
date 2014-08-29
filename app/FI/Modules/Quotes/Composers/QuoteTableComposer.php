<?php

namespace FI\Modules\Quotes\Composers;

use Config;
use FI\Statuses\QuoteStatuses;

class QuoteTableComposer {

	public function compose($view)
	{
		$view->with('statuses', QuoteStatuses::statuses())
		->with('mailConfigured', (Config::get('fi.mailDriver')) ? true : false);
	}

}