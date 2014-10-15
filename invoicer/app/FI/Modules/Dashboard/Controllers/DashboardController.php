<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Dashboard\Controllers;

use View;

use FI\Statuses\InvoiceStatuses;
use FI\Statuses\QuoteStatuses;

class DashboardController extends \BaseController {

	/**
	 * Activity Repository
	 * @var ActivityRepository
	 */
	protected $activity;
	
	/**
	 * Invoice repository
	 * @var InvoiceRepository
	 */
	protected $invoice;

	/**
	 * Quote repository
	 * @var QuoteRepository
	 */
	protected $quote;

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

	/**
	 * Dependency injection
	 * @param ActivityRepository $activity
	 * @param InvoiceRepository $invoice
	 * @param QuoteRepository $quote
	 * @param InvoiceAmountRepository $invoiceAmount
	 * @param QuoteAmountRepository $quoteAmount
	 */
	public function __construct($activity, $invoice, $quote, $invoiceAmount, $quoteAmount)
	{
		parent::__construct();

		$this->activity      = $activity;
		$this->invoice       = $invoice;
		$this->quote         = $quote;
		$this->invoiceAmount = $invoiceAmount;
		$this->quoteAmount   = $quoteAmount;
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