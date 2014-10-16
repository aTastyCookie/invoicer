<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Reports\Controllers;

use Input;
use Response;
use View;

use FI\Libraries\DateFormatter;

class RevenueByClientReportController extends \BaseController {

	/**
	 * Revenue by client report repository
	 * @var RevenueByClientReportRepository
	 */
	protected $revenueByClientReport;

	/**
	 * Date range validator
	 * @var ReportValidator
	 */
	protected $validator;

	/**
	 * Dependency injection
	 * @param RevenueByClientReportRepository $revenueByClientReport
	 * @param  ReportValidator $validator
	 */
	public function __construct($revenueByClientReport, $validator)
	{
		$this->revenueByClientReport = $revenueByClientReport;
		$this->validator             = $validator;
	}
	
	/**
	 * Display the report interface
	 * @return View
	 */
	public function index()
	{
		return View::make('reports.revenue_by_client')
		->with('years', $this->revenueByClientReport->getDistinctYears());
	}

	/**
	 * Run the report and display the results
	 * @return View
	 */
	public function ajaxRunReport()
	{
		$validator = $this->validator->getYearValidator(Input::all());

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'errors'  => $validator->messages()->toArray()
			), 400);
		}

		$months  = array();

		foreach(range(1, 12) as $month)
		{
			$months[$month] = DateFormatter::getMonthShortName($month);
		}

		return View::make('reports._revenue_by_client')
		->with('months', $months)
		->with('results', $this->revenueByClientReport->getResults(Input::get('year')));
	}

}