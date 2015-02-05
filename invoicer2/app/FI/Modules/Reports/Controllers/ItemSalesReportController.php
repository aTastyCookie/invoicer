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

class ItemSalesReportController extends BaseController {

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

	public function __construct()
	{
		$this->itemSalesReport = App::make('ItemSalesReportRepository');
		$this->validator       = App::make('ReportValidator');
	}
	
	/**
	 * Display the report interface
	 * @return View
	 */
	public function index()
	{
		return View::make('reports.item_sales');
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
		$results = $this->itemSalesReport->getResults(DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date')));

		return View::make('reports._item_sales')
			->with('results', $results);
	}

	public function pdf()
	{
		$pdf = PDFFactory::create();

		$results = $this->itemSalesReport->getResults(DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date')));

		$html = View::make('reports._item_sales')
			->with('results', $results)->render();

		$pdf->download($html, trans('fi.item_sales') . '.pdf');
	}

}