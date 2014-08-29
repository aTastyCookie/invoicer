<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('InvoiceTransactionRepository', 'FI\Modules\Merchant\Repositories\InvoiceTransactionRepository');

        $this->app->bind('MerchantController', function($app)
        {
            return new \FI\Modules\Merchant\Controllers\MerchantController(
                $app->make('InvoiceRepository'),
                $app->make('InvoiceTransactionRepository'),
                $app->make('PaymentRepository')
            );
        });
	}

}