<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('before' => 'auth', 'namespace' => 'FI\Modules\Reports\Controllers'), function()
{
    Route::get('reports/client_statement', array('uses' => 'ClientStatementReportController@index', 'as' => 'reports.clientStatement'));
	Route::post('reports/client_statement/validate', array('uses' => 'ClientStatementReportController@ajaxValidate', 'as' => 'reports.clientStatement.ajax.validate'));
	Route::get('reports/client_statement/html', array('uses' => 'ClientStatementReportController@html', 'as' => 'reports.clientStatement.html'));
	Route::get('reports/client_statement/pdf', array('uses' => 'ClientStatementReportController@pdf', 'as' => 'reports.clientStatement.pdf'));

	Route::get('reports/item_sales', array('uses' => 'ItemSalesReportController@index', 'as' => 'reports.itemSales'));
	Route::post('reports/item_sales/validate', array('uses' => 'ItemSalesReportController@ajaxValidate', 'as' => 'reports.itemSales.ajax.validate'));
	Route::get('reports/item_sales/html', array('uses' => 'ItemSalesReportController@html', 'as' => 'reports.itemSales.html'));
	Route::get('reports/item_sales/pdf', array('uses' => 'ItemSalesReportController@pdf', 'as' => 'reports.itemSales.pdf'));

	Route::get('reports/payments_collected', array('uses' => 'PaymentsCollectedReportController@index', 'as' => 'reports.paymentsCollected'));
	Route::post('reports/payments_collected/validate', array('uses' => 'PaymentsCollectedReportController@ajaxValidate', 'as' => 'reports.paymentsCollected.ajax.validate'));
	Route::get('reports/payments_collected/html', array('uses' => 'PaymentsCollectedReportController@html', 'as' => 'reports.paymentsCollected.html'));
	Route::get('reports/payments_collected/pdf', array('uses' => 'PaymentsCollectedReportController@pdf', 'as' => 'reports.paymentsCollected.pdf'));

	Route::get('reports/revenue_by_client', array('uses' => 'RevenueByClientReportController@index', 'as' => 'reports.revenueByClient'));
	Route::post('reports/revenue_by_client/validate', array('uses' => 'RevenueByClientReportController@ajaxValidate', 'as' => 'reports.revenueByClient.ajax.validate'));
	Route::get('reports/revenue_by_client/html', array('uses' => 'RevenueByClientReportController@html', 'as' => 'reports.revenueByClient.html'));
	Route::get('reports/revenue_by_client/pdf', array('uses' => 'RevenueByClientReportController@pdf', 'as' => 'reports.revenueByClient.pdf'));

	Route::get('reports/tax_summary', array('uses' => 'TaxSummaryReportController@index', 'as' => 'reports.taxSummary'));
	Route::post('reports/tax_summary/validate', array('uses' => 'TaxSummaryReportController@ajaxValidate', 'as' => 'reports.taxSummary.ajax.validate'));
	Route::get('reports/tax_summary/html', array('uses' => 'TaxSummaryReportController@html', 'as' => 'reports.taxSummary.html'));
	Route::get('reports/tax_summary/pdf', array('uses' => 'TaxSummaryReportController@pdf', 'as' => 'reports.taxSummary.pdf'));
});