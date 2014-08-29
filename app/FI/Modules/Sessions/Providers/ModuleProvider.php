<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Sessions\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('SessionValidator', 'FI\Modules\Sessions\Validators\SessionValidator');

        $this->app->bind('SessionController', function($app)
        {
            return new \FI\Modules\Sessions\Controllers\SessionController(
                $app->make('SessionValidator')
            );
        });
    }

}