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

class QuoteItemImporter extends AbstractImporter {

	public function getFields()
	{
		return array(
			'quote_id'    => '* ' . trans('fi.quote_number'),
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
			'quote_id' => 'required',
			'name'     => 'required',
			'quantity' => 'required',
			'price'    => 'required'
		);
	}

	public function getValidator($input)
	{
		return \Validator::make($input, array(
			'quote_id' => 'required',
			'name'     => 'required',
			'quantity' => 'required|numeric',
			'price'    => 'required|numeric'
			)
		);
	}

	public function importData($input)
	{
		$quoteItem = App::make('QuoteItemRepository');
		$quote     = App::make('QuoteRepository');
		$taxRate   = App::make('TaxRateRepository');

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
			$handle = fopen(Config::get('fi.uploadPath') . '/quoteItems.csv', 'r');
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

				$record['quote_id'] = $quote->findIdByNumber($record['quote_id']);

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
					
					$quoteItem->create($record);

					$quoteRecord = $quote->find($record['quote_id']);

					Event::fire('quote.modified', $quoteRecord);
				}
			}
			$row++;
		}

		fclose($handle);

		return true;
	}
}