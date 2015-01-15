<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Repositories;

use App;
use Config;
use Event;
use FI\Libraries\BaseRepository;
use FI\Libraries\DateFormatter;
use FI\Modules\Invoices\Models\RecurringInvoice;

class RecurringInvoiceRepository extends BaseRepository {

	public function __construct(RecurringInvoice $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a list of records
	 * @return Invoice
	 */
	public function getPaged()
	{
		$recurringInvoice = $this->model->has('invoice')->with('invoice')->orderBy('generate_at', 'DESC')->orderBy('id', 'DESC');

		return $recurringInvoice->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Create any new invoices from recurring
	 * @return int
	 */
	public function recurInvoices()
	{
		$invoiceCopy = App::make('InvoiceCopyRepository');

		$recurringInvoices = $this->model->recurNow()->get();

		foreach ($recurringInvoices as $recurringInvoice)
		{
			$newInvoice = $invoiceCopy->copyInvoice(
				$recurringInvoice->invoice_id, 
				$recurringInvoice->invoice->client->name, 
				$recurringInvoice->generate_at, 
				DateFormatter::incrementDateByDays(substr($recurringInvoice->generate_at, 0, 10), Config::get('fi.invoicesDueAfter')),
				$recurringInvoice->invoice->invoice_group_id,
				$recurringInvoice->invoice->user_id);

			$generateAt = DateFormatter::incrementDate(substr($recurringInvoice->generate_at, 0, 10), $recurringInvoice->recurring_period, $recurringInvoice->recurring_frequency);

			$this->update(array('generate_at' => $generateAt), $recurringInvoice->id);

			Event::fire('invoice.recurring', $newInvoice);
		}

		return count($recurringInvoices);
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return Invoice
	 */
	public function find($id)
	{
		return $this->model->with(array('items.amount', 'custom'))->find($id);
	}
	
}