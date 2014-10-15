<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Providers;

use Illuminate\Support\ServiceProvider;

use FI\Libraries\Directory;

use Paginator;

class StartProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->view->composer('layouts.master', 'FI\Composers\LayoutComposer');
        $this->app->view->composer('layouts.empty', 'FI\Composers\LayoutComposer');
        $this->app->view->composer('sessions.login', 'FI\Composers\LayoutComposer');

        $this->app->view->composer(Paginator::getViewName(), 'FI\Composers\PaginationComposer');
    }

    public function register()
    {
        // Register the config provider
        $this->app->register('FI\Providers\ConfigProvider');

        // Scan modules and register any available module providers
        $modules = Directory::listContents(__DIR__ . '/../Modules');

        // Include the module providers, views and routes
        foreach ($modules as $module)
        {
            if (file_exists(__DIR__ . '/../Modules/' . $module . '/Providers/ModuleProvider.php'))
            {
                $this->app->register('FI\Modules\\' . $module . '\Providers\ModuleProvider');
            }

            if (file_exists(__DIR__ . '/../Modules/' . $module . '/Views'))
            {
                $this->app->view->addLocation(__DIR__ . '/../Modules/' . $module . '/Views');
            }

            if (file_exists(__DIR__ . '/../Modules/' . $module . '/routes.php'))
            {
                require __DIR__ . '/../Modules/' . $module . '/routes.php';
            }
        }

        // Only register the setup provider if it exists
        if (file_exists(__DIR__ . '/../Modules/Setup/Providers/ModuleProvider.php'))
        {
            $this->app->register('FI\Modules\Setup\Providers\ModuleProvider');
        }
    }

}