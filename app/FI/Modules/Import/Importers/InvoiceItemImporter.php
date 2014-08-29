<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Import\Importers;

use App, Config, Event;

class InvoiceItemImporter extends AbstractImporter {

	public function getFields()
	{
		return array(
			'invoice_id'  => '* ' . trans('fi.invoice_number'),
			'name'        => '* ' . trans('fi.name'),
			'quantity'    => '* ' . trans('fi.quantity'),
			'price'       => '* ' . trans('fi.price'),
			'description' => trans('fi.description'),
			'tax_rate_id' => trans('fi.tax_rate')
		);
	}

	public function getMapRules()
	{
		return array(
			'invoice_id' => 'required',
			'name'       => 'required',
			'quantity'   => 'required',
			'price'      => 'required'
		);
	}

	public function getValidator($input)
	{
		return \Validator::make($input, array(
			'invoice_id' => 'required',
			'name'       => 'required',
			'quantity'   => 'required|numeric',
			'price'      => 'required|numeric'
			)
		);
	}

	public function importData($input)
	{
		$invoiceItem = App::make('InvoiceItemRepository');
		$invoice     = App::make('InvoiceRepository');
		$taxRate     = App::make('TaxRateRepository');

		$row = 1;

		$fields = array();

		foreach ($input as $field => $key)
		{
			if (is_numeric($key))
			{
				$fields[$key] = $field;
			}
		}

		try
		{
			$handle = fopen(Config::get('fi.uploadPath') . '/invoiceItems.csv', 'r');
		}

		catch (\ErrorException $e)
		{
			$this->messages->add('error', 'Could not open the file');
			return false;
		}

		while (($data = fgetcsv($handle, 1000, ',')) !== false)
		{
			if ($row !== 1)
			{
				$record = array();

				foreach ($fields as $key => $field)
				{
					$record[$field] = $data[$key];
				}

				$record['invoice_id'] = $invoice->findIdByNumber($record['invoice_id']);

				if (!isset($record['tax_rate_id']))
				{
					$record['tax_rate_id'] = 0;
				}
				else
				{
					$record['tax_rate_id'] = ($taxRate->findIdByName($record['tax_rate_id'])) ?: 0;
				}

				$record['display_order'] = 0;

				if ($this->validateRecord($record))
				{
					if (!isset($record['description'])) $record['description'] = '';

					$invoiceItem->create($record);

					$invoiceRecord = $invoice->find($record['invoice_id']);

					Event::fire('invoice.modified', $invoiceRecord);
				}
			}
			$row++;
		}

		fclose($handle);

		return true;
	}
}