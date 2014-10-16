<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Settings\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('SettingRepository', 'FI\Modules\Settings\Repositories\SettingRepository');

        $this->app->bind('SettingController', function($app)
        {
            return new \FI\Modules\Settings\Controllers\SettingController(
                $app->make('SettingRepository')
            );
        });
	}

}