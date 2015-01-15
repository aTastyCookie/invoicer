<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Reports\Repositories;

use Config;
use DB;
use FI\Libraries\CurrencyFormatter;
use FI\Libraries\DateFormatter;
use FI\Modules\Invoices\Models\Invoice;

class ClientStatementReportRepository {

    /**
     * Get the report results
     * @param  string $clientName
     * @param  string $fromDate
     * @param  string $toDate
     * @return array
     */
    public function getResults($clientName, $fromDate, $toDate)
    {
        $results = array(
            'subtotal' => 0,
            'tax'      => 0,
            'total'    => 0,
            'paid'     => 0,
            'balance'  => 0,
            'records'  => array()
        );

        $invoices = Invoice::with('client', 'amount')
            ->where('created_at', '>=', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->whereHas('client', function ($query) use ($clientName)
            {
                $query->where('name', $clientName);
            })
            ->orderBy('created_at')
            ->get();

        if ($invoices->count())
        {
            $client = $invoices->first()->client;

            foreach ($invoices as $invoice)
            {
                $results['records'][] = array(
                    'formatted_created_at' => $invoice->formatted_created_at,
                    'number'               => $invoice->number,
                    'description'          => implode('<br>', $invoice->items->lists('name')),
                    'subtotal'             => $invoice->amount->item_subtotal,
                    'tax'                  => $invoice->amount->item_tax_total + $invoice->amount->tax_total,
                    'total'                => $invoice->amount->total,
                    'paid'                 => $invoice->amount->paid,
                    'balance'              => $invoice->amount->balance,
                    'formatted_subtotal'   => $invoice->amount->formatted_item_subtotal,
                    'formatted_tax'        => $invoice->amount->formatted_total_tax,
                    'formatted_total'      => $invoice->amount->formatted_total,
                    'formatted_paid'       => $invoice->amount->formatted_paid,
                    'formatted_balance'    => $invoice->amount->formatted_balance
                );

                $results['subtotal'] += $invoice->amount->item_subtotal;
                $results['tax'] += $invoice->amount->item_tax_total + $invoice->amount->tax_total;
                $results['total'] += $invoice->amount->total;
                $results['paid'] += $invoice->amount->paid;
                $results['balance'] += $invoice->amount->balance;
            }
        }

        $results['client_name'] = $clientName;
        $results['from_date']   = DateFormatter::format($fromDate);
        $results['to_date']     = DateFormatter::format($toDate);
        $results['subtotal']    = CurrencyFormatter::format($results['subtotal'], (isset($client) ? $client->currency_code : Config::get('fi.baseCurrency')));
        $results['tax']         = CurrencyFormatter::format($results['tax'], (isset($client) ? $client->currency_code : Config::get('fi.baseCurrency')));
        $results['total']       = CurrencyFormatter::format($results['total'], (isset($client) ? $client->currency_code : Config::get('fi.baseCurrency')));
        $results['paid']        = CurrencyFormatter::format($results['paid'], (isset($client) ? $client->currency_code : Config::get('fi.baseCurrency')));
        $results['balance']     = CurrencyFormatter::format($results['balance'], (isset($client) ? $client->currency_code : Config::get('fi.baseCurrency')));

        return $results;
    }
}