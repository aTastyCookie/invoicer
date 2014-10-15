<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Clients\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('ClientRepository', 'FI\Modules\Clients\Repositories\ClientRepository');
        $this->app->bind('ClientValidator', 'FI\Modules\Clients\Validators\ClientValidator');

        $this->app->bind('ClientController', function($app)
        {
            return new \FI\Modules\Clients\Controllers\ClientController(
                $app->make('ClientRepository'),
                $app->make('ClientCustomRepository'),
                $app->make('CustomFieldRepository'),
                $app->make('ClientValidator')
            );
        });
	}

}