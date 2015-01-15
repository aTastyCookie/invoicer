<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Currencies\Repositories;

use Config;
use FI\Libraries\BaseRepository;
use FI\Modules\Clients\Models\Client;
use FI\Modules\Currencies\Models\Currency;
use FI\Modules\Invoices\Models\Invoice;
use FI\Modules\Quotes\Models\Quote;


class CurrencyRepository extends BaseRepository {

	public function __construct(Currency $model)
	{
		$this->model = $model;
	}

	/**
	 * Finds a currency by code
	 * @param  string $code
	 * @return Currency
	 */
	public function findByCode($code)
	{
		return $this->model->where('code', $code)->first();
	}

	/**
	 * Get a paged list of records
	 * @return Currency
	 */
	public function getPaged()
	{
		return $this->model->orderBy('name')->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Get a list of records formatted for dropdown
	 * @return array
	 */
	public function lists()
	{
		return $this->model->lists('name', 'code');
	}

	public function delete($id)
	{
		$currency = $this->model->find($id);

		if ($currency->code == Config::get('fi.baseCurrency'))
		{
			return trans('fi.cannot_delete_base_currency');
		}

		if (Client::where('currency_code', '=', $currency->code)->count())
		{
			return trans('fi.cannot_delete_client_currency');
		}

		if (Quote::where('currency_code', '=', $currency->code)->count())
		{
			return trans('fi.cannot_delete_quote_currency');
		}

		if (Invoice::where('currency_code', '=', $currency->code)->count())
		{
			return trans('fi.cannot_delete_invoice_currency');
		}

		$this->model->destroy($id);

		return trans('fi.record_successfully_deleted');
	}

	public function currencyInUse($id)
	{
		$currency = $this->model->find($id);

		if ($currency->code == Config::get('fi.baseCurrency'))
		{
			return true;
		}

		if (Client::where('currency_code', '=', $currency->code)->count())
		{
			return true;
		}

		if (Quote::where('currency_code', '=', $currency->code)->count())
		{
			return true;
		}

		if (Invoice::where('currency_code', '=', $currency->code)->count())
		{
			return true;
		}

		return false;
	}

}