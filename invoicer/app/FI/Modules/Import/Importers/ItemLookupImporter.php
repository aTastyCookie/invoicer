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

use App, Config;

class ItemLookupImporter extends AbstractImporter {

	public function getFields()
	{
		return array(
			'name'        => '* ' . trans('fi.name'),
			'description' => '* ' . trans('fi.description'),
			'price'       => '* ' . trans('fi.price')
		);
	}

	public function getMapRules()
	{
		return array(
			'name'        => 'required',
			'description' => 'required',
			'price'       => 'required'
		);
	}

	public function getValidator($input)
	{
		return App::make('ItemLookupValidator')->getValidator($input);
	}

	public function importData($input)
	{
		$repository = App::make('ItemLookupRepository');

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
			$handle = fopen(Config::get('fi.uploadPath') . '/itemLookups.csv', 'r');
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