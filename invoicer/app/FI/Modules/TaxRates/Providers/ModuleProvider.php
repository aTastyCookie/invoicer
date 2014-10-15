<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\TaxRates\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('TaxRateRepository', 'FI\Modules\TaxRates\Repositories\TaxRateRepository');
        $this->app->bind('TaxRateValidator', 'FI\Modules\TaxRates\Validators\TaxRateValidator');

        $this->app->bind('TaxRateController', function($app)
        {
            return new \FI\Modules\TaxRates\Controllers\TaxRateController(
                $app->make('TaxRateRepository'),
                $app->make('TaxRateValidator')
            );
        });
	}

}