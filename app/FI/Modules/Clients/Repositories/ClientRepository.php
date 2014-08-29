<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Clients\Repositories;

use App;
use Config;
use DB;
use FI\Modules\Clients\Models\Client;

class ClientRepository extends \FI\Libraries\BaseRepository {

	public function __construct(Client $model)
	{
		$this->model = $model;
	}
	
	/**
	 * Get a paged list of records
	 * @param  string  $status
	 * @param  string  $filter
	 * @return Client
	 */
	public function getPaged($status = null, $filter = null)
	{
		$client = $this->model->orderBy('name');

		if ($status == 'active')
			$client->where('active', 1);
		elseif ($status == 'inactive')
			$client->where('active', 0);

		if ($filter)
		{
			$client->keywords($filter);
		}

		return $client->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Provides a json encoded array of matching client names
	 * @param  string $name
	 * @return json
	 */
	public function lookupByName($name)
	{
		$clients = $this->model->select('name')
		->orderBy('name')
		->where('active', 1)
		->where('name', 'like', '%' . $name . '%')
		->get();

		$return = array();

		foreach ($clients as $client)
		{
			$return[]['value'] = $client->name;
		}

		return json_encode($return);
	}

	/**
	 * Retrieve a single client record
	 * @param  int $id
	 * @return Client
	 */
	public function find($id)
	{
		return $this->model->with('custom')->where('id', $id)->first();
	}

	/**
	 * Return client ID queried by name
	 * @param  string $name
	 * @return mixed
	 */
	public function findIdByName($name)
	{
		if ($client = $this->model->select('id')->where('name', $name)->first())
		{
			return $client->id;
		}

		return null;
	}

	public function firstOrCreate($name)
	{
		return $this->model->firstOrCreate(array('name' => $name));
	}
	
	/**
	 * Update a record
	 * @param  array $input
	 * @param  int $id
	 * @return Client
	 */
	public function update($input, $id)
	{
		$client = $this->model->find($id);

		$client->fill($input);
		
		$client->save();

		return $client;
	}
	
	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		$client = $this->model->find($id);

		// Let these repositories delete the child records.
		$invoice = App::make('InvoiceRepository');
		$quote   = App::make('QuoteRepository');

		// Delete the invoices.
		foreach ($client->invoices as $clientInvoice)
		{
			$invoice->delete($clientInvoice->id);
		}

		// Delete the quotes.
		foreach ($client->quotes as $clientQuote)
		{
			$quote->delete($clientQuote->id);
		}

		// Delete the custom fields.
		$client->custom()->delete();

		// Delete the client.
		$client->delete();
	}
	
}