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
use Auth;
use Config;
use Event;

use FI\Modules\Clients\Models\Client;
use FI\Modules\Invoices\Models\Invoice;
use FI\Modules\Invoices\Models\InvoiceItem;
use FI\Modules\Invoices\Models\InvoiceTaxRate;
use FI\Statuses\InvoiceStatuses;

class InvoiceCopyRepository {

    /**
     * Copies an invoice
     * @param  int $fromInvoiceId
     * @param  string $clientName
     * @param  date $createdAt
     * @param  date $dueAt
     * @param  int $invoiceGroupId
     * @param  int $userId
     * @return Invoice
     */
    public function copyInvoice($fromInvoiceId, $clientName, $createdAt, $dueAt, $invoiceGroupId, $userId)
    {
        $client = Client::firstOrCreate(array('name' => $clientName));

        $fromInvoice = Invoice::find($fromInvoiceId);

        $toInvoice = Invoice::create(
            array(
                'client_id'         => $client->id,
                'created_at'        => $createdAt,
                'due_at'            => $dueAt,
                'invoice_group_id'  => $invoiceGroupId,
                'number'            => App::make('InvoiceGroupRepository')->generateNumber($invoiceGroupId),
                'user_id'           => $userId,
                'invoice_status_id' => InvoiceStatuses::getStatusId('draft'),
                'url_key'           => str_random(32),
                'currency_code'     => $fromInvoice->currency_code,
                'exchange_rate'     => $fromInvoice->exchange_rate,
                'terms'             => $fromInvoice->terms,
                'footer'            => $fromInvoice->footer,
                'template'          => $fromInvoice->template
            )
        );

        App::make('InvoiceAmountRepository')->create($toInvoice->id);
        App::make('InvoiceGroupRepository')->incrementNextId($invoiceGroupId);

        $items = InvoiceItem::where('invoice_id', '=', $fromInvoiceId)->get();

        foreach ($items as $item)
        {
            $newItem = InvoiceItem::create(
                array(
                    'invoice_id'    => $toInvoice->id,
                    'name'          => $item->name,
                    'description'   => $item->description,
                    'quantity'      => $item->quantity,
                    'price'         => $item->price,
                    'tax_rate_id'   => $item->tax_rate_id,
                    'display_order' => $item->display_order
                )
            );

            Event::fire('invoice.item.created', $newItem->id);
        }

        $invoiceTaxRates = InvoiceTaxRate::where('invoice_id', '=', $fromInvoiceId)->get();

        foreach ($invoiceTaxRates as $invoiceTaxRate)
        {
            InvoiceTaxRate::create(
                array(
                    'invoice_id'       => $toInvoice->id,
                    'tax_rate_id'      => $invoiceTaxRate->tax_rate_id,
                    'include_item_tax' => $invoiceTaxRate->include_item_tax,
                    'tax_total'        => $invoiceTaxRate->tax_total
                )
            );
        }

        Event::fire('invoice.modified', $toInvoice);

        return $toInvoice;
    }

}