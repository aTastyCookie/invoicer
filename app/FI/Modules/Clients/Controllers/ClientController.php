<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Clients\Controllers;

use App;
use Config;
use FI\Libraries\BackPath;
use FI\Libraries\CustomFields;
use FI\Libraries\InvoiceTemplates;
use FI\Libraries\QuoteTemplates;
use Input;
use Redirect;
use Session;
use View;

class ClientController extends \BaseController {

    /**
     * Client repository
     * @var ClientRepository
     */
    protected $client;

    /**
     * Client custom repository
     * @var ClientCustomRepository
     */
    protected $clientCustom;

    /**
     * Custom field repository
     * @var CustomFieldRepository
     */
    protected $customField;

    /**
     * Client validator
     * @var ClientValidator
     */
    protected $validator;

    /**
     * Dependency injection
     * @param ClientRepository $client
     * @param ClientCustomRepository $clientCustom
     * @param CustomFieldRepository $customField
     * @param ClientValidator $validator
     */
    public function __construct($client, $clientCustom, $customField, $validator)
    {
        parent::__construct();

        $this->client       = $client;
        $this->clientCustom = $clientCustom;
        $this->customField  = $customField;
        $this->validator    = $validator;
    }

    /**
     * Display paginated list
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $status = (Input::get('status')) ? : 'all';

        $clients = $this->client->getPaged($status, Input::get('search'));

        return View::make('clients.index')
            ->with('clients', $clients)
            ->with('status', $status)
            ->with('filterRoute', route('clients.index', array($status)));
    }

    /**
     * Display form for new record
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('clients.form')
            ->with('editMode', false)
            ->with('customFields', $this->customField->getByTable('clients'))
            ->with('currencies', App::make('CurrencyRepository')->lists())
            ->with('invoiceTemplates', InvoiceTemplates::lists())
            ->with('quoteTemplates', QuoteTemplates::lists());
    }

    /**
     * Validate and handle new record form submission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $input = Input::all();

        if (Input::has('custom'))
        {
            $custom = $input['custom'];
            unset($input['custom']);
        }

        $validator = $this->validator->getValidator($input);

        if ($validator->fails($input))
        {
            return Redirect::route('clients.create')
                ->with('editMode', false)
                ->withErrors($validator)
                ->withInput();
        }

        $clientId = $this->client->create($input)->id;

        if (Input::has('custom'))
        {
            $this->clientCustom->save($custom, $clientId);
        }

        return Redirect::to(BackPath::getBackPath('clients/index'))
            ->with('alertSuccess', trans('fi.record_successfully_created'));
    }

    /**
     * Display a single record
     * @param  int $clientId
     * @return \Illuminate\View\View
     */
    public function show($clientId)
    {
        $client = $this->client->find($clientId);

        $invoices = $client->invoices()
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->take(Config::get('fi.defaultNumPerPage'))->get();

        $quotes = $client->quotes()
            ->orderBy('created_at', 'DESC')
            ->orderBy('id', 'DESC')
            ->take(Config::get('fi.defaultNumPerPage'))->get();

        return View::make('clients.view')
            ->with('client', $client)
            ->with('invoices', $invoices)
            ->with('quotes', $quotes)
            ->with('customFields', $this->customField->getByTable('clients'));
    }

    /**
     * Display form for existing record
     * @param  int $clientId
     * @return \Illuminate\View\View
     */
    public function edit($clientId)
    {
        $client = $this->client->find($clientId);

        return View::make('clients.form')
            ->with('editMode', true)
            ->with('client', $client)
            ->with('customFields', $this->customField->getByTable('clients'))
            ->with('currencies', App::make('CurrencyRepository')->lists())
            ->with('invoiceTemplates', InvoiceTemplates::lists())
            ->with('quoteTemplates', QuoteTemplates::lists());
    }

    /**
     * Validate and handle existing record form submission
     * @param  int $clientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($clientId)
    {
        $input = Input::all();

        if (Input::has('custom'))
        {
            $custom = $input['custom'];
            unset($input['custom']);
        }

        $validator = $this->validator->getUpdateValidator($input, $clientId);

        if ($validator->fails($input))
        {
            return Redirect::route('clients.edit', array($clientId))
                ->with('editMode', true)
                ->withErrors($validator)
                ->withInput();
        }

        $this->client->update($input, $clientId);

        if (Input::has('custom'))
        {
            $this->clientCustom->save($custom, $clientId);
        }

        return Redirect::to(BackPath::getBackPath('clients/index'))
            ->with('alertInfo', trans('fi.record_successfully_updated'));
    }

    /**
     * Delete a record
     * @param  int $clientId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($clientId)
    {
        $this->client->delete($clientId);

        return Redirect::route('clients.index')
            ->with('alert', trans('fi.record_successfully_deleted'));
    }

    /**
     * Return a json list of records matching the provided query
     * @return json
     */
    public function ajaxNameLookup()
    {
        return $this->client->lookupByName(Input::get('query'));
    }
}