<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\InvoiceGroups\Repositories;

use Config;
use FI\Modules\InvoiceGroups\Models\InvoiceGroup;

class InvoiceGroupRepository {
	
	/**
	 * Get all records
	 * @return InvoiceGroup
	 */
	public function all()
	{
		return InvoiceGroup::orderBy('name')->all();
	}

	/**
	 * Get a paged list of records
	 * @return InvoiceGroup
	 */
	public function getPaged()
	{
		return InvoiceGroup::paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return InvoiceGroup
	 */
	public function find($id)
	{
		return InvoiceGroup::find($id);
	}

	public function findIdByName($name)
	{
		if ($invoiceGroup = InvoiceGroup::where('name', $name)->first())
		{
			return $invoiceGroup->id;
		}
		return null;
	}

	/**
	 * Generate an invoice number
	 * @param  int $id
	 * @return string
	 */
	public function generateNumber($id)
	{
		$group = InvoiceGroup::find($id);

		$nextId = str_pad($group->next_id, $group->left_pad, '0', STR_PAD_LEFT);

		$number = '';

		if ($group->prefix) $number       .= $group->prefix;
		if ($group->prefix_year) $number  .= date('Y');
		if ($group->prefix_month) $number .= date('m');

		$number .= $nextId;

		return $number;
	}

	/**
	 * Increment the next id after an invoice is created
	 * @param  int $id
	 * @return void
	 */
	public function incrementNextId($id)
	{
		$group          = InvoiceGroup::find($id);
		$group->next_id = $group->next_id + 1;
		$group->save();
	}

	/**
	 * Get a list of records formatted for dropdown
	 * @return array
	 */
	public function lists()
	{
		return InvoiceGroup::orderBy('name')->lists('name', 'id');
	}
	
	/**
	 * Create a record
	 * @param  array $input
	 * @return int
	 */
	public function create($input)
	{
		return InvoiceGroup::create($input);
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $id
	 * @return void
	 */
	public function update($input, $id)
	{
		$invoiceGroup = InvoiceGroup::find($id);

		$invoiceGroup->fill($input);

		$invoiceGroup->save();

		return $invoiceGroup;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		InvoiceGroup::destroy($id);
	}
	
}