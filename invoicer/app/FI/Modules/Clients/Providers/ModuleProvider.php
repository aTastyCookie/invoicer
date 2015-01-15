<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
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
	}

}