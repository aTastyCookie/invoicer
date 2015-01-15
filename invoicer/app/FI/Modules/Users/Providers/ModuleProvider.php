<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Users\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('UserRepository', 'FI\Modules\Users\Repositories\UserRepository');
        $this->app->bind('UserValidator', 'FI\Modules\Users\Validators\UserValidator');
    }

}