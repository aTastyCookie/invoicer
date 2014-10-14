<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Reports\Repositories;

use FI\Libraries\CurrencyFormatter;
use FI\Libraries\NumberFormatter;
use FI\Modules\Invoices\Models\Invoice;

class TaxSummaryReportRepository {

    /**
     * Get the report results
     * @param  string $fromDate
     * @param  string $toDate
     * @return array
     */
    public function getResults($fromDate, $toDate)
    {
        $results = array();

        $invoices = Invoice::where('created_at', '>=', $fromDate)->where('created_at', '<=', $toDate)->get();

        foreach ($invoices as $invoice)
        {
            foreach ($invoice->taxRates as $invoiceTaxRate)
            {
                $key = $invoiceTaxRate->taxRate->name . ' (' . NumberFormatter::format($invoiceTaxRate->taxRate->percent) . '%)';

                if (isset($results[$key]['taxable_amount']))
                {
                    $results[$key]['taxable_amount'] += $invoice->amount->item_subtotal / $invoice->exchange_rate;
                    $results[$key]['taxes'] += $invoiceTaxRate->tax_total / $invoice->exchange_rate;
                }
                else
                {
                    $results[$key]['taxable_amount'] = $invoice->amount->item_subtotal / $invoice->exchange_rate;
                    $results[$key]['taxes']          = $invoiceTaxRate->tax_total / $invoice->exchange_rate;
                }

            }

            foreach ($invoice->items as $invoiceItem)
            {
                if ($invoiceItem->tax_rate_id)
                {
                    $key = $invoiceItem->taxRate->name . ' (' . NumberFormatter::format($invoiceItem->taxRate->percent) . '%)';
                }

                if (isset($results[$key]['taxable_amount']))
                {
                    $results[$key]['taxable_amount'] += $invoiceItem->amount->subtotal / $invoice->exchange_rate;
                    $results[$key]['taxes'] += $invoiceItem->amount->tax_total / $invoice->exchange_rate;
                }
                else
                {
                    $results[$key]['taxable_amount'] = $invoiceItem->amount->subtotal / $invoice->exchange_rate;
                    $results[$key]['taxes']          = $invoiceItem->amount->tax_total / $invoice->exchange_rate;
                }
            }

        }

        foreach ($results as $key => $result)
        {
            $results[$key]['taxable_amount'] = CurrencyFormatter::format($result['taxable_amount']);
            $results[$key]['taxes']          = CurrencyFormatter::format($result['taxes']);
        }

        return $results;
    }

}