<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->view->composer('invoices._table', 'FI\Modules\Invoices\Composers\InvoiceTableComposer');
    }

	public function register()
	{
        $this->app->register('FI\Modules\Invoices\Providers\EventProvider');

        $this->app->bind('InvoiceAmountRepository', 'FI\Modules\Invoices\Repositories\InvoiceAmountRepository');
        $this->app->bind('InvoiceCopyRepository', 'FI\Modules\Invoices\Repositories\InvoiceCopyRepository');
        $this->app->bind('InvoiceItemAmountRepository', 'FI\Modules\Invoices\Repositories\InvoiceItemAmountRepository');
        $this->app->bind('InvoiceItemRepository', 'FI\Modules\Invoices\Repositories\InvoiceItemRepository');
        $this->app->bind('InvoiceRepository', 'FI\Modules\Invoices\Repositories\InvoiceRepository');
        $this->app->bind('InvoiceTaxRateRepository', 'FI\Modules\Invoices\Repositories\InvoiceTaxRateRepository');
        $this->app->bind('RecurringInvoiceRepository', 'FI\Modules\Invoices\Repositories\RecurringInvoiceRepository');

        $this->app->bind('InvoiceValidator', 'FI\Modules\Invoices\Validators\InvoiceValidator');
        $this->app->bind('InvoiceItemValidator', 'FI\Validators\ItemValidator');
        $this->app->bind('InvoiceTaxRateValidator', 'FI\Modules\Invoices\Validators\InvoiceTaxRateValidator');

        $this->app->bind('InvoiceMailer', 'FI\Modules\Invoices\Mail\InvoiceMailer');
        
        $this->app->bind('InvoiceController', function($app)
        {
            return new \FI\Modules\Invoices\Controllers\InvoiceController(
                $app->make('InvoiceRepository'),
                $app->make('InvoiceGroupRepository'),
                $app->make('InvoiceItemRepository'),
                $app->make('InvoiceTaxRateRepository'),
                $app->make('InvoiceValidator')
            );
        });

        $this->app->bind('RecurringController', function($app)
        {
            return new \FI\Modules\Invoices\Controllers\RecurringController(
                $app->make('RecurringInvoiceRepository')
            );
        });

        $this->app->bind('PublicInvoiceController', function($app)
        {
            return new \FI\Modules\Invoices\Controllers\PublicInvoiceController(
                $app->make('InvoiceRepository')
            );
        });

        // Register artisan command for recurring invoices
        $this->app['command.fi.recurring'] = $this->app->share(function($app)
        {
            return new \FI\Modules\Invoices\Commands\Recurring();
        });

        $this->commands('command.fi.recurring');
	}

}