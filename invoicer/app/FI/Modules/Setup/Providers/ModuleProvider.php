<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Setup\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('SetupValidator', 'FI\Modules\Setup\Validators\SetupValidator');

        $this->app->bind('SetupController', function($app)
        {
            return new \FI\Modules\Setup\Controllers\SetupController(
            	$app->make('SettingRepository'),
            	$app->make('UserRepository'),
            	$app->make('SetupValidator')
            );
        });
	}

}