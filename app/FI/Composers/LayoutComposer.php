<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Composers;

use Request;

class LayoutComposer {

	public function compose($view)
	{
		$view->with('protocol', (Request::secure()) ? 'https' : 'http');
	}

}