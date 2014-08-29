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

use App, Config;

class ClientImporter extends AbstractImporter {

	public function getFields()
	{
		return array(
			'name'    => '* ' . trans('fi.name'),
			'address' => trans('fi.address'),
			'phone'   => trans('fi.phone'),
			'fax'     => trans('fi.fax'),
			'mobile'  => trans('fi.mobile'),
			'email'   => trans('fi.email'),
			'web'     => trans('fi.web')
		);
	}

	public function getMapRules()
	{
		return array(
			'name' => 'required'
		);
	}

	public function getValidator($input)
	{
		return App::make('ClientValidator')->getValidator($input);
	}

	public function importData($input)
	{
		$repository = App::make('ClientRepository');

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
			$handle = fopen(Config::get('fi.uploadPath') . '/clients.csv', 'r');
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