<?php

namespace FI\Composers;

use Input, Paginator;

class PaginationComposer {

	public function compose($view)
	{
		$query = array_except( Input::query(), Paginator::getPageName() );
		$view->paginator->appends($query);
	}

}