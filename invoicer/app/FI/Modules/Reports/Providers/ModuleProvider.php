<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Reports\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider {

	public function register()
	{
        $this->app->bind('ItemSalesReportRepository', 'FI\Modules\Reports\Repositories\ItemSalesReportRepository');
        $this->app->bind('PaymentsCollectedReportRepository', 'FI\Modules\Reports\Repositories\PaymentsCollectedReportRepository');
        $this->app->bind('RevenueByClientReportRepository', 'FI\Modules\Reports\Repositories\RevenueByClientReportRepository');
        $this->app->bind('TaxSummaryReportRepository', 'FI\Modules\Reports\Repositories\TaxSummaryReportRepository');

        $this->app->bind('ReportValidator', 'FI\Modules\Reports\Validators\ReportValidator');

        $this->app->bind('ItemSalesReportController', function($app)
        {
            return new \FI\Modules\Reports\Controllers\ItemSalesReportController(
                $app->make('ItemSalesReportRepository'),
                $app->make('ReportValidator')
            );
        });

        $this->app->bind('PaymentsCollectedReportController', function($app)
        {
            return new \FI\Modules\Reports\Controllers\PaymentsCollectedReportController(
                $app->make('PaymentsCollectedReportRepository'),
                $app->make('ReportValidator')
            );
        });

        $this->app->bind('RevenueByClientReportController', function($app)
        {
            return new \FI\Modules\Reports\Controllers\RevenueByClientReportController(
                $app->make('RevenueByClientReportRepository'),
                $app->make('ReportValidator')
            );
        });

        $this->app->bind('TaxSummaryReportController', function($app)
        {
            return new \FI\Modules\Reports\Controllers\TaxSummaryReportController(
                $app->make('TaxSummaryReportRepository'),
                $app->make('ReportValidator')
            );
        });
	}

}