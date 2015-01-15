<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Dashboard\Controllers;

use App;
use BaseController;
use View;

class DashboardController extends BaseController {

	/**
	 * Activity Repository
	 * @var ActivityRepository
	 */
	protected $activity;

	/**
	 * Invoice amount repository
	 * @var InvoiceAmountRepository
	 */
	protected $invoiceAmount;

	/**
	 * Quote amount repository
	 * @var QuoteAmountRepository
	 */
	protected $quoteAmount;

	public function __construct()
	{
		parent::__construct();

		$this->activity      = App::make('ActivityRepository');
		$this->invoiceAmount = App::make('InvoiceAmountRepository');
		$this->quoteAmount   = App::make('QuoteAmountRepository');
	}

	/**
	 * Display the dashboard
	 * @return View
	 */
	public function index()
	{
		return View::make('dashboard.index')
		->with('recentClientActivity', $this->activity->getRecentClientActivity())
		->with('invoicesTotalDraft', $this->invoiceAmount->getTotalDraft())
		->with('invoicesTotalSent', $this->invoiceAmount->getTotalSent())
		->with('invoicesTotalPaid', $this->invoiceAmount->getTotalPaid())
		->with('invoicesTotalOverdue', $this->invoiceAmount->getTotalOverdue())
		->with('quotesTotalDraft', $this->quoteAmount->getTotalDraft())
		->with('quotesTotalSent', $this->quoteAmount->getTotalSent())
		->with('quotesTotalApproved', $this->quoteAmount->getTotalApproved())
		->with('quotesTotalRejected', $this->quoteAmount->getTotalRejected());
	}

}