<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
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

        $this->app->bind('UserController', function($app)
        {
            return new \FI\Modules\Users\Controllers\UserController(
                $app->make('CustomFieldRepository'),
                $app->make('UserRepository'),
                $app->make('UserCustomRepository'),
                $app->make('UserValidator')
            );
        });

        $this->app->bind('UserPasswordController', function($app)
        {
            return new \FI\Modules\Users\Controllers\UserPasswordController(
                $app->make('UserRepository'),
                $app->make('UserValidator')
            );
        });
    }

}