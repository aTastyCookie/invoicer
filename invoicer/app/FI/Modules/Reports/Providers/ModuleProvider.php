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
        $this->app->bind('ClientStatementReportRepository', 'FI\Modules\Reports\Repositories\ClientStatementReportRepository');
        $this->app->bind('ItemSalesReportRepository', 'FI\Modules\Reports\Repositories\ItemSalesReportRepository');
        $this->app->bind('PaymentsCollectedReportRepository', 'FI\Modules\Reports\Repositories\PaymentsCollectedReportRepository');
        $this->app->bind('RevenueByClientReportRepository', 'FI\Modules\Reports\Repositories\RevenueByClientReportRepository');
        $this->app->bind('TaxSummaryReportRepository', 'FI\Modules\Reports\Repositories\TaxSummaryReportRepository');

        $this->app->bind('ClientStatementReportValidator', 'FI\Modules\Reports\Validators\ClientStatementReportValidator');
        $this->app->bind('ReportValidator', 'FI\Modules\Reports\Validators\ReportValidator');
	}

}