<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Reports\Controllers;

use Input;
use Response;
use View;

use FI\Libraries\DateFormatter;

class PaymentsCollectedReportController extends \BaseController {

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

	/**
	 * Dependency injection
	 * @param PaymentsCollectedReportRepository $paymentsCollectedReport
	 */
	public function __construct($paymentsCollectedReport, $validator)
	{
		$this->paymentsCollectedReport = $paymentsCollectedReport;
		$this->validator               = $validator;
	}
	
	/**
	 * Display the report interface
	 * @return View
	 */
	public function index()
	{
		return View::make('reports.payments_collected');
	}

	/**
	 * Run the report and display the results
	 * @return View
	 */
	public function ajaxRunReport()
	{
		$validator = $this->validator->getDateRangeValidator(Input::all());

		if ($validator->fails())
		{
			return Response::json(array(
				'success' => false,
				'errors'  => $validator->messages()->toArray()
			), 400);
		}

		return View::make('reports._payments_collected')
		->with('results', $this->paymentsCollectedReport->getResults(DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date'))));
	}

}