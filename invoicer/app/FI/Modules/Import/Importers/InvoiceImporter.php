<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Import\Importers;

use App, Auth, Config, Validator;

use FI\Libraries\DateFormatter;

class InvoiceImporter extends AbstractImporter {

	public function getFields()
	{
		return array(
			'created_at'       => '* ' . trans('fi.date'),
			'client_name'      => '* ' . trans('fi.client_name'),
			'number'           => '* ' . trans('fi.invoice_number'),
			'invoice_group_id' => trans('fi.group'),
			'due_at'           => trans('fi.due_date'),
			'terms'            => trans('fi.terms_and_conditions')
		);
	}

	public function getMapRules()
	{
		return array(
			'created_at'  => 'required',
			'client_name' => 'required',
			'number'      => 'required'
		);
	}

	public function getValidator($input)
	{
		return App::make('InvoiceValidator')->getRawValidator($input);
	}

	public function importData($input)
	{
		$repository = App::make('InvoiceRepository');

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
			$handle = fopen(Config::get('fi.uploadPath') . '/invoices.csv', 'r');
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

				// Create the initial record from the file line
				foreach ($fields as $key => $field)
				{
					$record[$field] = $data[$key];
				}

				// Replace the client name with the client id
				$record['client_id'] = App::make('ClientRepository')->firstOrCreate($record['client_name'])->id;
				unset($record['client_name']);

				// Format the created at date
				if (strtotime($record['created_at']))
				{
					$record['created_at'] = date('Y-m-d', strtotime($record['created_at']));
				}
				else
				{
					$record['created_at'] = date('Y-m-d');
				}

				// Attempt to format this date if it exists
				// Otherwise generate date based on config setting
				if (isset($record['due_at']) and strtotime($record['due_at']))
				{
					$record['due_at'] = date('Y-m-d', strtotime($record['due_at']));
				}
				else
				{
					$record['due_at'] = DateFormatter::incrementDateByDays($record['created_at'], Config::get('fi.invoicesDueAfter'));
				}
				
				// Attempt to convert the invoice group name to an id
				// Otherwise default to default id from config setting
				if (isset($record['invoice_group_id']))
				{
					if (!$record['invoice_group_id'] = App::make('InvoiceGroupRepository')->findIdByName($record['invoice_group_id']))
					{
						$record['invoice_group_id'] = Config::get('fi.invoiceGroup');
					}
				}
				else
				{
					$record['invoice_group_id'] = Config::get('fi.invoiceGroup');
				}

				// Assign the invoice to the current logged in user
				$record['user_id'] = Auth::user()->id;

				// Set the invoice status to draft on import
				$record['invoice_status_id'] = 1;

				// Set the url key
				$record['url_key'] = str_random(32);

				// Default the footer
				$record['footer'] = Config::get('fi.invoiceFooter');

				// The record *should* validate, but just in case...
				if ($this->validateRecord($record))
				{
					$repository->create($record);
				}
			}
			$row++;
		}

		fclose($handle);

		return true;
	}
}