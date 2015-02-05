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
use FI\Statuses\QuoteStatuses;

class QuoteImporter extends AbstractImporter {

	public function getFields()
	{
		return array(
			'created_at'       => '* ' . trans('fi.date'),
			'client_name'      => '* ' . trans('fi.client_name'),
			'number'           => '* ' . trans('fi.quote_number'),
			'invoice_group_id' => trans('fi.group'),
			'quote_status_id'  => trans('fi.status'),
			'expires_at'       => trans('fi.expires')
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
		return App::make('QuoteValidator')->getRawValidator($input);
	}

	public function importData($input)
	{
		$repository = App::make('QuoteRepository');

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
			$handle = fopen(Config::get('fi.uploadPath') . '/quotes.csv', 'r');
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
				if (isset($record['expires_at']) and strtotime($record['expires_at']))
				{
					$record['expires_at'] = date('Y-m-d', strtotime($record['expires_at']));
				}
				else
				{
					$record['expires_at'] = DateFormatter::incrementDateByDays($record['created_at'], Config::get('fi.quotesExpireAfter'));
				}
				
				// Attempt to convert the invoice group name to an id
				// Otherwise default to default id from config setting
				if (isset($record['invoice_group_id']))
				{
					if (!$record['invoice_group_id'] = App::make('InvoiceGroupRepository')->findIdByName($record['invoice_group_id']))
					{
						$record['invoice_group_id'] = Config::get('fi.quoteGroup');
					}
				}
				else
				{
					$record['invoice_group_id'] = Config::get('fi.quoteGroup');
				}

				// Assign the quote to the current logged in user
				$record['user_id'] = Auth::user()->id;

				// If a proper quote status ID has not been provided, default to sent
				if (!isset($record['quote_status_id']) or !in_array($record['quote_status_id'], QuoteStatuses::statuses()))
				{
					$record['quote_status_id'] = QuoteStatuses::getStatusId('draft');
				}

				// Set the url key
				$record['url_key'] = str_random(32);

				// Default the footer
				$record['footer'] = Config::get('fi.quoteFooter');

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