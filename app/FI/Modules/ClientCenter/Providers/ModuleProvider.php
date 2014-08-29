<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\ClientCenter\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
		$this->app->register('FI\Modules\ClientCenter\Providers\EventProvider');

		$this->app->bind('ClientCenterInvoiceController', function($app)
		{
			return new \FI\Modules\ClientCenter\Controllers\ClientCenterInvoiceController(
				$app->make('InvoiceRepository')
			);
		});

		$this->app->bind('ClientCenterQuoteController', function($app)
		{
			return new \FI\Modules\ClientCenter\Controllers\ClientCenterQuoteController(
				$app->make('QuoteRepository')
			);
		});
	}

}