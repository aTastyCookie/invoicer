<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('DashboardController', function($app)
        {
            return new \FI\Modules\Dashboard\Controllers\DashboardController(
                $app->make('ActivityRepository'),
                $app->make('InvoiceRepository'),
                $app->make('QuoteRepository'),
                $app->make('InvoiceAmountRepository'),
                $app->make('QuoteAmountRepository')
            );
        });
	}

}