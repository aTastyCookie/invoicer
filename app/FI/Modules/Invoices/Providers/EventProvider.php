<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Providers;

use App;
use Config;
use Event;
use FI\Calculators\InvoiceCalculator;
use FI\Libraries\Parser;
use FI\Statuses\InvoiceStatuses;
use Illuminate\Support\ServiceProvider;

class EventProvider extends ServiceProvider {

	/**
	 * Register the service provider
	 * @return void
	 */
	public function register()
	{
		$this->app->register('FI\Modules\Payments\Providers\EventProvider');
	}

	/**
	 * Bootstrap the application events
	 * @return void
	 */
	public function boot()
	{
		Event::listen('invoice.created', function($invoice, $includeDefaultTaxRate)
		{
			$invoiceAmount = App::make('InvoiceAmountRepository');
			$invoiceGroup  = App::make('InvoiceGroupRepository');

			// Create the empty invoice amount record
			$invoiceAmount->create($invoice->id);
			
			// Increment the next id
			$invoiceGroup->incrementNextId($invoice->invoice_group_id);

			// Create the default tax rate if applicable
			if ($includeDefaultTaxRate and Config::get('fi.invoiceTaxRate'))
			{
				$invoiceTaxRate = App::make('InvoiceTaxRateRepository');

				$invoiceTaxRate->create(array('invoice_id' => $invoice->id, 'tax_rate_id' => Config::get('fi.invoiceTaxRate'), 'include_item_tax' => Config::get('fi.includeItemTax')));
			}
		});

		// Create the invoice item amount record
		Event::listen('invoice.item.created', function($itemId)
		{
			$invoiceItem       = App::make('InvoiceItemRepository');
			$invoiceItemAmount = App::make('InvoiceItemAmountRepository');
			$taxRate           = App::make('TaxRateRepository');

			$invoiceItem = $invoiceItem->find($itemId);

			if ($invoiceItem->tax_rate_id)
			{
				$taxRatePercent = $taxRate->find($invoiceItem->tax_rate_id)->percent;
			}
			else
			{
				$taxRatePercent = 0;
			}

			$subtotal = $invoiceItem->quantity * $invoiceItem->price;
			$taxTotal = $subtotal * ($taxRatePercent / 100);
			$total    = $subtotal + $taxTotal;

			$invoiceItemAmount->create(
				array(
					'item_id'   => $invoiceItem->id,
					'subtotal'  => $subtotal,
					'tax_total' => $taxTotal,
					'total'     => $total
					)
				);
		});

		// Calculate all invoice amounts
		Event::listen('invoice.modified', function($invoiceRecord)
		{
			// Resolve ALL THE THINGS
			$invoice           = App::make('InvoiceRepository');
			$invoiceItem       = App::make('InvoiceItemRepository');
			$invoiceItemAmount = App::make('InvoiceItemAmountRepository');
			$invoiceAmount     = App::make('InvoiceAmountRepository');
			$invoiceTaxRate    = App::make('InvoiceTaxRateRepository');
			$taxRate           = App::make('TaxRateRepository');
			$payment           = App::make('PaymentRepository');

			// Retrieve the required records
			$items           = $invoiceItem->findByInvoiceId($invoiceRecord->id);
			$invoiceTaxRates = $invoiceTaxRate->findByInvoiceId($invoiceRecord->id);
			$totalPaid       = $payment->getTotalPaidByInvoiceId($invoiceRecord->id);

			// Set up the calculator
			$calculator = new InvoiceCalculator;
			$calculator->setId($invoiceRecord->id);
			$calculator->setTotalPaid($totalPaid);

			// Add the items to be calculated
			foreach ($items as $item)
			{
				if ($item->tax_rate_id)
				{
					$taxRatePercent = $taxRate->find($item->tax_rate_id)->percent;
				}
				else
				{
					$taxRatePercent = 0;
				}

				$calculator->addItem($item->id, $item->quantity, $item->price, $taxRatePercent);
			}

			// Add the invoice tax rates to be calculated
			foreach ($invoiceTaxRates as $invoiceTax)
			{
				$taxRatePercent = $taxRate->find($invoiceTax->tax_rate_id)->percent;

				$calculator->addTaxRate($invoiceTax->tax_rate_id, $taxRatePercent, $invoiceTax->include_item_tax);
			}

			// Run the calculations
			$calculator->calculate();

			// Get the calculated values
			$calculatedItemAmounts = $calculator->getCalculatedItemAmounts();
			$calculatedTaxRates    = $calculator->getCalculatedTaxRates();
			$calculatedAmount      = $calculator->getCalculatedAmount();

			// Update the item amount records
			foreach ($calculatedItemAmounts as $calculatedItemAmount)
			{
				$invoiceItemAmount->update($calculatedItemAmount, $calculatedItemAmount['item_id']);
			}

			// Update the invoice tax rate records
			foreach ($calculatedTaxRates as $calculatedTaxRate)
			{
				$invoiceTaxRate->updateInvoiceTaxRate($calculatedTaxRate, $invoiceRecord->id, $calculatedTaxRate['tax_rate_id']);
			}

			// Update the invoice amount record
			$invoiceAmount->update($calculatedAmount, $invoiceRecord->id);

			// Check to see if the invoice should be marked as paid
			if ($calculatedAmount['total'] > 0 and $calculatedAmount['balance'] <= 0)
			{
				$invoice->update(array('invoice_status_id' => InvoiceStatuses::getStatusId('paid')), $invoiceRecord->id);
			}

			// Check to see if the invoice was marked as paid but should no longer be
			$invoiceStatusId = $invoice->find($invoiceRecord->id)->invoice_status_id;

			if ($calculatedAmount['total'] > 0 and $calculatedAmount['balance'] > 0 and $invoiceStatusId == InvoiceStatuses::getStatusId('paid'))
			{
				$invoice->update(array('invoice_status_id' => InvoiceStatuses::getStatusId('sent')), $invoiceRecord->id);
			}
		});

		Event::listen('invoice.emailed', function($invoice)
		{
			// Change the status to sent if the status is currently draft
			if ($invoice->invoice_status_id == InvoiceStatuses::getStatusId('draft'))
			{
				$invoice->invoice_status_id = InvoiceStatuses::getStatusId('sent');
				$invoice->save();
			}
		});

		Event::listen('invoice.recurring', function($invoice)
		{
			if (Config::get('fi.automaticEmailOnRecur') and $invoice->client->email)
			{
				$invoiceMailer = App::make('InvoiceMailer');

				$template = ($invoice->is_overdue) ? Config::get('fi.overdueInvoiceEmailBody') : Config::get('fi.invoiceEmailBody');

				$invoiceMailer->send($invoice, $invoice->client->email, trans('fi.invoice') . ' #' . $invoice->number, Parser::parse($invoice, $template), null, (Config::get('fi.attachPdf')) ? true : false);
			}
		});

	}
}