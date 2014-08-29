<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

    public function boot()
    {
        $this->app->view->composer('quotes._table', 'FI\Modules\Quotes\Composers\QuoteTableComposer');
    }

	public function register()
	{
        $this->app->register('FI\Modules\Quotes\Providers\EventProvider');

        $this->app->bind('QuoteAmountRepository', 'FI\Modules\Quotes\Repositories\QuoteAmountRepository');
        $this->app->bind('QuoteCopyRepository', 'FI\Modules\Quotes\Repositories\QuoteCopyRepository');
        $this->app->bind('QuoteInvoiceRepository', 'FI\Modules\Quotes\Repositories\QuoteInvoiceRepository');
        $this->app->bind('QuoteItemAmountRepository', 'FI\Modules\Quotes\Repositories\QuoteItemAmountRepository');
        $this->app->bind('QuoteItemRepository', 'FI\Modules\Quotes\Repositories\QuoteItemRepository');
        $this->app->bind('QuoteRepository', 'FI\Modules\Quotes\Repositories\QuoteRepository');
        $this->app->bind('QuoteTaxRateRepository', 'FI\Modules\Quotes\Repositories\QuoteTaxRateRepository');

        $this->app->bind('QuoteTaxRateValidator', 'FI\Modules\Quotes\Validators\QuoteTaxRateValidator');
        $this->app->bind('QuoteValidator', 'FI\Modules\Quotes\Validators\QuoteValidator');

        $this->app->bind('QuoteMailer', 'FI\Modules\Quotes\Mail\QuoteMailer');

        $this->app->bind('PublicQuoteController', function($app)
        {
            return new \FI\Modules\Quotes\Controllers\PublicQuoteController(
                $app->make('QuoteRepository')
            );
        });

        $this->app->bind('QuoteController', function($app)
        {
            return new \FI\Modules\Quotes\Controllers\QuoteController(
                $app->make('InvoiceGroupRepository'),
                $app->make('QuoteItemRepository'),
                $app->make('QuoteRepository'),
                $app->make('QuoteTaxRateRepository'),
                $app->make('QuoteValidator')
            );
        });
	}

}