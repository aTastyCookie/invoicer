<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Providers;

use App;
use Config;
use Event;
use FI\Calculators\QuoteCalculator;
use FI\Statuses\QuoteStatuses;
use Illuminate\Support\ServiceProvider;


class EventProvider extends ServiceProvider {

	/**
	 * Register the service provider
	 * @return void
	 */
	public function register() {}

	/**
	 * Bootstrap the application events
	 * @return void
	 */
	public function boot()
	{
		Event::listen('quote.created', function($quote)
		{
			$quoteAmount  = App::make('QuoteAmountRepository');
			$invoiceGroup = App::make('InvoiceGroupRepository');

			// Create the empty quote amount record			
			$quoteAmount->create($quote->id);

			// Increment the next id
			$invoiceGroup->incrementNextId($quote->invoice_group_id);

			// Create the default tax rate if applicable
			if (Config::get('fi.invoiceTaxRate'))
			{
				$quoteTaxRate = App::make('QuoteTaxRateRepository');

				$quoteTaxRate->create(array('quote_id' => $quote->id, 'tax_rate_id' => Config::get('fi.invoiceTaxRate'), 'include_item_tax' => Config::get('fi.includeItemTax')));
			}
		});

		// Create the quote item amount record
		Event::listen('quote.item.created', function($itemId)
		{
			$quoteItem       = App::make('QuoteItemRepository');
            $quoteItemAmount = App::make('QuoteItemAmountRepository');
            $taxRate         = App::make('TaxRateRepository');

            $quoteItem = $quoteItem->find($itemId);

            if ($quoteItem->tax_rate_id)
            {
                    $taxRatePercent = $taxRate->find($quoteItem->tax_rate_id)->percent;
            }
            else
            {
                    $taxRatePercent = 0;
            }

            $subtotal = $quoteItem->quantity * $quoteItem->price;
            $taxTotal = $subtotal * ($taxRatePercent / 100);
            $total    = $subtotal + $taxTotal;

            $quoteItemAmount->create(
            	array(
                    'item_id'   => $quoteItem->id,
                    'subtotal'  => $subtotal,
                    'tax_total' => $taxTotal,
                    'total'     => $total
                )
            );
		});

		// Calculate all quote amounts
		Event::listen('quote.modified', function($quote)
		{
			// Resolve ALL THE THINGS
			$quoteItem       = App::make('QuoteItemRepository');
			$quoteItemAmount = App::make('QuoteItemAmountRepository');
			$quoteAmount     = App::make('QuoteAmountRepository');
			$quoteTaxRate    = App::make('QuoteTaxRateRepository');
			$taxRate         = App::make('TaxRateRepository');

			// Retrieve the required records
			$items         = $quoteItem->findByQuoteId($quote->id);
			$quoteTaxRates = $quoteTaxRate->findByQuoteId($quote->id);

			// Set up the calculator
			$calculator = new QuoteCalculator;
			$calculator->setId($quote->id);

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

			// Add the quote tax rates to be calculated
			foreach ($quoteTaxRates as $quoteTax)
			{
				$taxRatePercent = $taxRate->find($quoteTax->tax_rate_id)->percent;

				$calculator->addTaxRate($quoteTax->tax_rate_id, $taxRatePercent, $quoteTax->include_item_tax);
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
				$quoteItemAmount->update($calculatedItemAmount, $calculatedItemAmount['item_id']);
			}

			// Update the quote tax rate records
			foreach ($calculatedTaxRates as $calculatedTaxRate)
			{
				$quoteTaxRate->updateQuoteTaxRate($calculatedTaxRate, $quote->id, $calculatedTaxRate['tax_rate_id']);
			}

			// Update the quote amount record
			$quoteAmount->update($calculatedAmount, $quote->id);
		});

		Event::listen('quote.emailed', function($quote)
		{
			// Change the status to sent if the status is currently draft
			if ($quote->quote_status_id == QuoteStatuses::getStatusId('draft'))
			{
				$quote->quote_status_id = QuoteStatuses::getStatusId('sent');
				$quote->save();
			}
		});
	}
}