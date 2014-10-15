<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\CustomFields\Repositories;

use Config;
use FI\Modules\CustomFields\Models\CustomField;
use Schema;

class CustomFieldRepository {
	
	/**
	 * Get a list of all records
	 * @return CustomField
	 */
	public function all()
	{
		return CustomField::all();
	}

	/**
	 * Get a paged list of records
	 * @return CustomField
	 */
	public function getPaged()
	{
		return CustomField::orderBy('table_name', 'field_label')->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return CustomField
	 */
	public function find($id)
	{
		return CustomField::find($id);
	}

	/**
	 * Get a list by table name
	 * @param  string $table
	 * @return CustomField
	 */
	public function getByTable($table)
	{
		return CustomField::forTable($table)->get();
	}

	/**
	 * Create a record
	 * @param  array $input
	 * @return CustomField
	 */
	public function create($input)
	{
		return CustomField::create($input);
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $id
	 * @return CustomField
	 */
	public function update($input, $id)
	{
		$customField = CustomField::find($id);

		$customField->fill($input);

		$customField->save();

		return $customField;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		CustomField::destroy($id);
	}

	/**
	 * Obtains the new column name (incremental) to add for a custom field
	 * @param  string $tableName
	 * @return string
	 */
	public function getNextColumnName($tableName)
	{
		$currentColumn = CustomField::where('table_name', '=', $tableName)->orderBy('id', 'DESC')->take(1)->first();

		if (!$currentColumn)
		{
			return 'column_1';
		}
		else
		{
			$column = explode('_', $currentColumn->column_name);

			return $column[0] . '_' . ($column[1] + 1);exit;
		}
	}

	/**
	 * Creates the new column
	 * @param  string $tableName
	 * @param  string $columnName
	 * @param  string $fieldType
	 * @return void
	 */
	public function createCustomColumn($tableName, $columnName, $fieldType)
	{
		if (substr($tableName, -7) <> '_custom')
		{
			$tableName = $tableName . '_custom';
		}

		Schema::table($tableName, function($table) use ($columnName, $fieldType)
		{
			if ($fieldType == 'textarea')
			{
				$table->text($columnName);
			}
			else
			{
				$table->string($columnName);
			}
			
		});
	}

	/**
	 * Drops a custom column
	 * @param  string $tableName
	 * @param  string $columnName
	 * @return void
	 */
	public function deleteCustomColumn($tableName, $columnName)
	{
		if (substr($tableName, -7) <> '_custom')
		{
			$tableName = $tableName . '_custom';
		}

		if (Schema::hasColumn($tableName, $columnName))
		{
			Schema::table($tableName, function ($table) use ($columnName)
			{
				$table->dropColumn($columnName);
			});
		}
	}
	
}