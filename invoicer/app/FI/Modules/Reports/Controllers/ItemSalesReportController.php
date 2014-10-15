<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Reports\Controllers;

use Input;
use Response;
use View;

use FI\Libraries\DateFormatter;

class ItemSalesReportController extends \BaseController {

	/**
	 * Item sales report repository
	 * @var ItemSalesReportRepository
	 */
	protected $itemSalesReport;

	/**
	 * Date range validator
	 * @var ReportValidator
	 */
	protected $validator;

	/**
	 * Dependency injection
	 * @param ItemSalesReportRepository $itemSalesReport
	 * @param ReportValidator $validator
	 */
	public function __construct($itemSalesReport, $validator)
	{
		$this->itemSalesReport = $itemSalesReport;
		$this->validator       = $validator;
	}
	
	/**
	 * Display the report interface
	 * @return View
	 */
	public function index()
	{
		return View::make('reports.item_sales');
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

		return View::make('reports._item_sales')
		->with('results', $this->itemSalesReport->getResults(DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date'))));
	}

}