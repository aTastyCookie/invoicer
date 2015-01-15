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

class ClientStatementReportController extends BaseController {

    /**
     * Client statement report repository
     * @var ClientStatementReportRepository
     */
    protected $clientStatementReport;

    /**
     * Date range validator
     * @var ClientStatementReportValidator
     */
    protected $validator;

    public function __construct()
    {
        $this->clientStatementReport = App::make('ClientStatementReportRepository');
        $this->validator             = App::make('ClientStatementReportValidator');
    }

    /**
     * Display the report interface
     * @return View
     */
    public function index()
    {
        return View::make('reports.client_statement');
    }

    public function ajaxValidate()
    {
        $validator = $this->validator->getValidator(Input::all());

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
        $results = $this->clientStatementReport->getResults(Input::get('client_name'), DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date')));

        return View::make('reports._client_statement')
            ->with('results', $results);
    }

    public function pdf()
    {
        $pdf = PDFFactory::create();

        $results = $this->clientStatementReport->getResults(Input::get('client_name'), DateFormatter::unformat(Input::get('from_date')), DateFormatter::unformat(Input::get('to_date')));

        $html = View::make('reports._client_statement')
            ->with('results', $results)->render();

        $pdf->download($html, trans('fi.client_statement') . '.pdf');
    }

}