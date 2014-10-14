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
use FI\Modules\Invoices\Models\Invoice;
use FI\Modules\Payments\Models\Payment;

class RevenueByClientReportRepository {

	/**
	 * Returns a distinct set of years in which payments have been made
	 * @return array
	 */
	public function getDistinctYears()
	{
		$return = array();

		$years = Payment::select(\DB::raw("YEAR(created_at) AS year"))->distinct()->orderBy(\DB::raw("YEAR(created_at)"))->get();

		foreach ($years as $year)
		{
			$return[$year->year] = $year->year;
		}

		return $return;
	}	
	
	/**
	 * Get the report results
	 * @param  int $year
	 * @return array
	 */
	public function getResults($year)
	{
		$results = array();

		$payments = Payment::byYear($year)->get();

		foreach ($payments as $payment)
		{
			if (isset($results[$payment->invoice->client->name]['months'][date('n', strtotime($payment->paid_at))]))
			{
				$results[$payment->invoice->client->name]['months'][date('n', strtotime($payment->paid_at))] += $payment->amount / $payment->invoice->exchange_rate;
			}
			else
			{
				$results[$payment->invoice->client->name]['months'][date('n', strtotime($payment->paid_at))] = $payment->amount / $payment->invoice->exchange_rate;
			}
		}

		foreach ($results as $client => $result)
		{
			$results[$client]['total'] = 0;

			foreach (range(1, 12) as $month)
			{
				if (!isset($results[$client]['months'][$month]))
				{
					$results[$client]['months'][$month] = CurrencyFormatter::format(0);
				}
				else
				{	
					$results[$client]['total'] += $results[$client]['months'][$month];
					$results[$client]['months'][$month] = CurrencyFormatter::format($results[$client]['months'][$month]);
				}
			}
			$results[$client]['total'] = CurrencyFormatter::format($results[$client]['total']);
		}

		return $results;
	}
	
}