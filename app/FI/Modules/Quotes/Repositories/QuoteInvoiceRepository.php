<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Repositories;

use App;
use Event;
use FI\Statuses\InvoiceStatuses;

class QuoteInvoiceRepository {

	public function quoteToInvoice($quote, $createdAt, $dueAt, $invoiceGroupId)
	{
		$invoice        = App::make('InvoiceRepository');
		$invoiceGroup   = App::make('InvoiceGroupRepository');
		$invoiceItem    = App::make('InvoiceItemRepository');
		$invoiceTaxRate = App::make('InvoiceTaxRateRepository');
		$quoteItem      = App::make('QuoteItemRepository');
		$quoteTaxRate   = App::make('QuoteTaxRateRepository');

		$record = array(
			'client_id'         => $quote->client_id,
			'created_at'        => $createdAt,
			'due_at'            => $dueAt,
			'invoice_group_id'  => $invoiceGroupId,
			'number'            => $invoiceGroup->generateNumber($invoiceGroupId),
			'user_id'           => $quote->user_id,
			'invoice_status_id' => InvoiceStatuses::getStatusId('draft'),
			'url_key'           => str_random(32),
			'terms'             => $quote->terms,
			'footer'            => $quote->footer,
			'currency_code'     => $quote->currency_code,
			'exchange_rate'     => $quote->exchange_rate
		);

		$toInvoice = $invoice->create($record, false);

		$items = $quoteItem->findByQuoteId($quote->id);

		foreach ($items as $item)
		{
			$itemRecord = array(
				'invoice_id'    => $toInvoice->id,
				'name'          => $item->name,
				'description'   => $item->description,
				'quantity'      => $item->quantity,
				'price'         => $item->price,
				'tax_rate_id'   => $item->tax_rate_id,
				'display_order' => $item->display_order
			);

			$itemId = $invoiceItem->create($itemRecord)->id;
		}

		$quoteTaxRates = $quoteTaxRate->findByQuoteId($quote->id);

		foreach ($quoteTaxRates as $quoteTaxRate)
		{
			$invoiceTaxRate->create(
				array(
					'invoice_id'       => $toInvoice->id,
					'tax_rate_id'      => $quoteTaxRate->tax_rate_id,
					'include_item_tax' => $quoteTaxRate->include_item_tax,
					'tax_total'        => $quoteTaxRate->tax_total
					)
				);
		}

		Event::fire('invoice.modified', array($toInvoice));

		return $toInvoice;
	}

}