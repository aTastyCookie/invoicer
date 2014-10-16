<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Repositories;

use App;
use Auth;
use Config;
use Event;
use FI\Libraries\DateFormatter;
use FI\Modules\Clients\Models\Client;
use FI\Modules\Quotes\Models\Quote;
use FI\Modules\Quotes\Models\QuoteItem;
use FI\Modules\Quotes\Models\QuoteTaxRate;
use FI\Statuses\QuoteStatuses;

class QuoteCopyRepository {

    /**
     * Copies a quote
     * @param  int $fromQuoteId
     * @param  string $clientName
     * @param  date $createdAt
     * @param  date $expiresAt
     * @param  int $invoiceGroupId
     * @param  int $userId
     * @return Quote
     */
    public function copyQuote($fromQuoteId, $clientName, $createdAt, $expiresAt, $invoiceGroupId, $userId)
    {
        $fromQuote = Quote::find($fromQuoteId);
        $client    = Client::firstOrCreate(array('name' => $clientName));

        $toQuote = Quote::create(
            array(
                'client_id'        => $client->id,
                'created_at'       => $createdAt,
                'expires_at'       => $expiresAt,
                'invoice_group_id' => $invoiceGroupId,
                'number'           => App::make('InvoiceGroupRepository')->generateNumber($invoiceGroupId),
                'user_id'          => $userId,
                'quote_status_id'  => QuoteStatuses::getStatusId('draft'),
                'url_key'          => str_random(32),
                'currency_code'    => $fromQuote->currency_code,
                'exchange_rate'    => $fromQuote->exchange_rate,
                'terms'            => $fromQuote->terms,
                'footer'           => $fromQuote->footer,
                'template'         => $fromQuote->template
            )
        );

        App::make('QuoteAmountRepository')->create($toQuote->id);
        App::make('InvoiceGroupRepository')->incrementNextId($invoiceGroupId);

        $items = QuoteItem::where('quote_id', '=', $fromQuoteId)->get();

        foreach ($items as $item)
        {
            $newItem = QuoteItem::create(
                array(
                    'quote_id'      => $toQuote->id,
                    'name'          => $item->name,
                    'description'   => $item->description,
                    'quantity'      => $item->quantity,
                    'price'         => $item->price,
                    'tax_rate_id'   => $item->tax_rate_id,
                    'display_order' => $item->display_order
                )
            );

            Event::fire('quote.item.created', $newItem->id);
        }

        $quoteTaxRates = QuoteTaxRate::where('quote_id', '=', $fromQuoteId)->get();

        foreach ($quoteTaxRates as $quoteTaxRate)
        {
            QuoteTaxRate::create(
                array(
                    'quote_id'         => $toQuote->id,
                    'tax_rate_id'      => $quoteTaxRate->tax_rate_id,
                    'include_item_tax' => $quoteTaxRate->include_item_tax,
                    'tax_total'        => $quoteTaxRate->tax_total
                )
            );
        }

        Event::fire('quote.modified', $toQuote);

        return $toQuote;
    }

}