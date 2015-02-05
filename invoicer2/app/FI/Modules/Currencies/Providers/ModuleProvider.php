<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Currencies\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('CurrencyRepository', 'FI\Modules\Currencies\Repositories\CurrencyRepository');
        $this->app->bind('CurrencyValidator', 'FI\Modules\Currencies\Validators\CurrencyValidator');

        $this->app->bind('CurrencyConverter', function()
        {
            return new \FI\Modules\Currencies\Libraries\YQLCurrencyConverter;
        });
    }

}