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

use App;
use BaseController;
use FI\Libraries\PDF\PDFFactory;
use Input;
use Response;
use View;

use FI\Libraries\DateFormatter;

class RevenueByClientReportController extends BaseController {

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

	public function __construct()
	{
		$this->revenueByClientReport = App::make('RevenueByClientReportRepository');
		$this->validator             = App::make('ReportValidator');
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

	public function ajaxValidate()
	{
		$validator = $this->validator->getYearValidator(Input::all());

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'errors'  => $validator->messages()->toArray()
			), 400);
		}

		return Response::json(array('success' => true));
	}

	public function html()
	{
		$results = $this->revenueByClientReport->getResults(Input::get('year'));

		$months  = array();

		foreach(range(1, 12) as $month)
		{
			$months[$month] = DateFormatter::getMonthShortName($month);
		}

		return View::make('reports._revenue_by_client')
			->with('results', $results)
			->with('months', $months);
	}

	public function pdf()
	{
		$pdf = PDFFactory::create();

		$results = $this->revenueByClientReport->getResults(Input::get('year'));

		$months  = array();

		foreach(range(1, 12) as $month)
		{
			$months[$month] = DateFormatter::getMonthShortName($month);
		}

		$html = View::make('reports._revenue_by_client')
			->with('results', $results)
			->with('months', $months)
			->render();

		$pdf->setPaperOrientation('landscape');
		$pdf->download($html, trans('fi.revenue_by_client') . '.pdf');
	}

}