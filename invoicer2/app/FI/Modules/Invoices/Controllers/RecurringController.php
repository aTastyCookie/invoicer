<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Controllers;

use App;
use BaseController;
use FI\Libraries\Frequency;
use Input;
use Redirect;
use View;

class RecurringController extends BaseController {

	/**
	 * Recurring invoice repository
	 * @var RecurringInvoiceRepository
	 */
	protected $recurringInvoice;

	public function __construct()
	{
		$this->recurringInvoice = App::make('RecurringInvoiceRepository');
	}

	/**
	 * Display paginated list
	 * @return View
	 */
	public function index()
	{
		$recurringInvoices = $this->recurringInvoice->getPaged();

		return View::make('recurring.index')
		->with('recurringInvoices', $recurringInvoices)
		->with('frequencies', Frequency::lists());
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return Redirect
	 */
	public function delete($id)
	{
		$this->recurringInvoice->delete($id);

		return Redirect::route('recurring.index');
	}

	public function generateRecurring()
	{
		$count = \App::make('RecurringInvoiceRepository')->recurInvoices();

		return 'Recurring invoices generated: ' . $count;
	}
}