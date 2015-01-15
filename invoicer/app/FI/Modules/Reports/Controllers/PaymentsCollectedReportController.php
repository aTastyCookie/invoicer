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

class PaymentsCollectedReportController extends BaseController {

	/**
	 * Payments collected report repository
	 * @var PaymentsCollectedReportRepository
	 */
	protected $paymentsCollectedReport;

	/**
	 * Date range validator
	 * @var ReportValidator
	 */
	protected $validator;

	public function __construct()
	{
		$this->paymentsCollectedReport = App::make('PaymentsCollectedReportRepository');
		$this->validator               = App::make('ReportValidator');
	}

	/**
	 * Display the report interface
	 * @return View
	 */
	public function index()
	{
		return View::make('reports.payments_collected');
	}

	public function ajaxValidate()
	{
		$validator = $this->validator->getDateRangeValidator(Input::all());

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
		$results = $this->paymentsCollectedReport->getResults(DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date')));

		return View::make('reports._payments_collected')
			->with('results', $results);
	}

	public function pdf()
	{
		$pdf = PDFFactory::create();

		$results = $this->paymentsCollectedReport->getResults(DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date')));

		$html = View::make('reports._payments_collected')
			->with('results', $results)->render();

		$pdf->download($html, trans('fi.payments_collected') . '.pdf');
	}

}