<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Controllers;

use App;
use Auth;
use BaseController;
use Config;
use Event;
use FI\Libraries\BackPath;
use FI\Libraries\DateFormatter;
use FI\Libraries\FileNames;
use FI\Libraries\NumberFormatter;
use FI\Libraries\Parser;
use FI\Libraries\PDF\PDFFactory;
use FI\Libraries\QuoteTemplates;
use FI\Statuses\QuoteStatuses;
use Input;
use Redirect;
use Response;
use Session;
use View;

class QuoteController extends BaseController {

    /**
     * Invoice group repository
     * @var InvoiceGroupRepository
     */
    protected $invoiceGroup;

    /**
     * Quote repository
     * @var QuoteRepository
     */
    protected $quote;

    /**
     * Quote item repository
     * @var QuoteItemRepository
     */
    protected $quoteItem;

    /**
     * Quote tax rate repository
     * @var QuoteTaxRateRepository
     */
    protected $quoteTaxRate;

    /**
     * Quote validator
     * @var QuoteValidator
     */
    protected $validator;

    public function __construct()
    {
        parent::__construct();

        $this->invoiceGroup = App::make('InvoiceGroupRepository');
        $this->quote        = App::make('QuoteRepository');
        $this->quoteItem    = App::make('QuoteItemRepository');
        $this->quoteTaxRate = App::make('QuoteTaxRateRepository');
        $this->validator    = App::make('QuoteValidator');
    }

    /**
     * Display paginated list
     * @return View
     */
    public function index()
    {
        $status = (Input::get('status')) ?: 'all';

        $quotes   = $this->quote->getPagedByStatus($status, Input::get('search'), Input::get('client'));
        $statuses = QuoteStatuses::statuses();

        return View::make('quotes.index')
            ->with('quotes', $quotes)
            ->with('status', $status)
            ->with('statuses', $statuses)
            ->with('filterRoute', route('quotes.index', array($status)));
    }

    /**
     * Accept post data to create quote
     * @return json
     */
    public function store()
    {
        $client = App::make('ClientRepository');

        $validator = $this->validator->getValidator(Input::all());

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        $quoteClient = $client->firstOrCreate(Input::get('client_name'));

        $input = array(
            'client_id'        => $quoteClient->id,
            'created_at'       => DateFormatter::unformat(Input::get('created_at')),
            'expires_at'       => DateFormatter::incrementDateByDays(DateFormatter::unformat(Input::get('created_at')), Config::get('fi.quotesExpireAfter')),
            'invoice_group_id' => Input::get('invoice_group_id'),
            'number'           => $this->invoiceGroup->generateNumber(Input::get('invoice_group_id')),
            'user_id'          => Auth::user()->id,
            'quote_status_id'  => QuoteStatuses::getStatusId('draft'),
            'url_key'          => str_random(32),
            'terms'            => Config::get('fi.quoteTerms'),
            'footer'           => Config::get('fi.quoteFooter'),
            'currency_code'    => $quoteClient->currency_code,
            'exchange_rate'    => '',
            'template'          => $quoteClient->quote_template
        );

        $quoteId = $this->quote->create($input)->id;

        return Response::json(array('success' => true, 'id' => $quoteId), 200);
    }

    /**
     * Accept post data to update quote
     * @param int $id
     * @return json
     */
    public function update($id)
    {
        $validator = $this->validator->getUpdateValidator(Input::all());

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        foreach (json_decode(Input::get('items')) as $item)
        {
            $itemValidator = App::make('InvoiceItemValidator')->getValidator($item);

            if ($itemValidator->fails())
            {
                return Response::json(array(
                    'success' => false,
                    'errors'  => $itemValidator->messages()->toArray()
                ), 400);
            }
        }

        $input = Input::all();

        $custom = (array)json_decode($input['custom']);
        unset($input['custom']);

        $quote = array(
            'number'          => $input['number'],
            'created_at'      => DateFormatter::unformat($input['created_at']),
            'expires_at'      => DateFormatter::unformat($input['expires_at']),
            'quote_status_id' => $input['quote_status_id'],
            'terms'           => $input['terms'],
            'footer'          => $input['footer'],
            'currency_code'   => $input['currency_code'],
            'exchange_rate'   => $input['exchange_rate'],
            'template'        => $input['template']
        );

        $quote = $this->quote->update($quote, $id);

        App::make('QuoteCustomRepository')->save($custom, $id);

        $items = json_decode(Input::get('items'));

        foreach ($items as $item)
        {
            if ($item->item_name)
            {
                $itemRecord = array(
                    'quote_id'      => $item->quote_id,
                    'name'          => $item->item_name,
                    'description'   => $item->item_description,
                    'quantity'      => NumberFormatter::unformat($item->item_quantity),
                    'price'         => ((!Input::get('apply_exchange_rate')) ? NumberFormatter::unformat($item->item_price) : (NumberFormatter::unformat($item->item_price) * Input::get('exchange_rate'))),
                    'tax_rate_id'   => $item->item_tax_rate_id,
                    'display_order' => $item->item_order
                );

                if (!$item->item_id)
                {
                    $itemId = $this->quoteItem->create($itemRecord)->id;
                }
                else
                {
                    $this->quoteItem->update($itemRecord, $item->item_id);
                }

                if (isset($item->save_item_as_lookup) and $item->save_item_as_lookup)
                {
                    $itemLookup = App::make('ItemLookupRepository');

                    $itemLookupRecord = array(
                        'name'        => $item->item_name,
                        'description' => $item->item_description,
                        'price'       => NumberFormatter::unformat($item->item_price)
                    );

                    $itemLookup->create($itemLookupRecord);
                }
            }
        }

        Event::fire('quote.modified', $quote);

        Session::flash('alertInfo', trans('fi.quote_successfully_updated'));

        return Response::json(array('success' => true), 200);
    }

    /**
     * Display the quote
     * @param  int $id [description]
     * @return View
     */
    public function edit($id)
    {
        return View::make('quotes.edit')
            ->with('quote', $this->quote->find($id))
            ->with('statuses', QuoteStatuses::lists())
            ->with('currencies', App::make('CurrencyRepository')->lists())
            ->with('taxRates', App::make('TaxRateRepository')->lists())
            ->with('quoteTaxRates', $this->quoteTaxRate->findByQuoteId($id))
            ->with('customFields', App::make('CustomFieldRepository')->getByTable('quotes'))
            ->with('backPath', BackPath::getBackPath())
            ->with('templates', QuoteTemplates::lists());
    }

    /**
     * Delete an item from a quote
     * @param  int $quoteId
     * @param  int $itemId
     * @return Redirect
     */
    public function deleteItem($quoteId, $itemId)
    {
        $this->quoteItem->delete($itemId);

        return Redirect::route('quotes.edit', array($quoteId));
    }

    /**
     * Displays create quote modal from ajax request
     * @return View
     */
    public function modalCreate()
    {
        return View::make('quotes._modal_create')
            ->with('invoiceGroups', $this->invoiceGroup->lists());
    }

    /**
     * Displays modal to convert quote to invoice
     * @return view
     */
    public function modalQuoteToInvoice()
    {
        return View::make('quotes._modal_quote_to_invoice')
            ->with('quote_id', Input::get('quote_id'))
            ->with('client_id', Input::get('client_id'))
            ->with('invoiceGroups', $this->invoiceGroup->lists())
            ->with('user_id', Auth::user()->id)
            ->with('created_at', DateFormatter::format());
    }

    /**
     * Displays modal to copy quote
     * @return View
     */
    public function modalCopyQuote()
    {
        $quote = $this->quote->find(Input::get('quote_id'));

        return View::make('quotes._modal_copy_quote')
            ->with('quote', $quote)
            ->with('invoiceGroups', $this->invoiceGroup->lists())
            ->with('created_at', DateFormatter::format())
            ->with('user_id', Auth::user()->id);
    }

    /**
     * Attempt to copy a quote
     * @return Redirect
     */
    public function copyQuote()
    {
        $validator = $this->validator->getValidator(Input::all());

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        $quoteCopy = App::make('QuoteCopyRepository');

        $quoteId = $quoteCopy->copyQuote(Input::get('quote_id'), Input::get('client_name'), DateFormatter::unformat(Input::get('created_at')), DateFormatter::incrementDateByDays(DateFormatter::unformat(Input::get('created_at')), Config::get('fi.quotesExpireAfter')), Input::get('invoice_group_id'), Auth::user()->id)->id;

        return Response::json(array('success' => true, 'id' => $quoteId), 200);
    }

    /**
     * Attempt to save quote to invoice
     * @return view
     */
    public function quoteToInvoice()
    {
        $input = Input::all();

        $validator = $this->validator->getToInvoiceValidator($input);

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        $quote = $this->quote->find($input['quote_id']);

        $invoice = App::make('QuoteInvoiceRepository')->quoteToInvoice(
            $quote,
            DateFormatter::unformat($input['created_at']),
            DateFormatter::incrementDateByDays(DateFormatter::unformat($input['created_at']), Config::get('fi.invoicesDueAfter')),
            $input['invoice_group_id']
        );

        return Response::json(array('success' => true, 'redirectTo' => route('invoices.edit', array('invoice' => $invoice->id))), 200);
    }

    /**
     * Displays modal to add quote taxes from ajax request
     * @return View
     */
    public function modalAddQuoteTax()
    {
        $taxRates = App::make('TaxRateRepository')->lists();

        return View::make('quotes._modal_add_quote_tax')
            ->with('quote_id', Input::get('quote_id'))
            ->with('taxRates', $taxRates)
            ->with('includeItemTax', array('0' => trans('fi.apply_before_item_tax'), '1' => trans('fi.apply_after_item_tax')));
    }

    /**
     * Saves quote tax from ajax request
     */
    public function saveQuoteTax()
    {
        $validator = App::make('QuoteTaxRateValidator')->getValidator(Input::all());

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        $this->quoteTaxRate->create(
            array(
                'quote_id'         => Input::get('quote_id'),
                'tax_rate_id'      => Input::get('tax_rate_id'),
                'include_item_tax' => Input::get('include_item_tax')
            )
        );

        return Response::json(array('success' => true), 200);
    }

    /**
     * Deletes quote tax
     * @param  int $quoteId
     * @param  int $quoteTaxRateId
     * @return Redirect
     */
    public function deleteQuoteTax($quoteId, $quoteTaxRateId)
    {
        $this->quoteTaxRate->delete($quoteTaxRateId);

        return Redirect::route('quotes.edit', array($quoteId));
    }

    /**
     * Deletes a quote
     * @param  int $quoteId
     * @return Redirect
     */
    public function delete($quoteId)
    {
        $this->quote->delete($quoteId);

        return Redirect::route('quotes.index')
            ->with('alert', trans('fi.record_successfully_deleted'));
    }

    /**
     * Display the modal to send mail
     * @return View
     */
    public function modalMailQuote()
    {
        $quote = $this->quote->find(Input::get('quote_id'));

        return View::make('quotes._modal_mail')
            ->with('quoteId', $quote->id)
            ->with('redirectTo', Input::get('redirectTo'))
            ->with('to', $quote->client->email)
            ->with('cc', Config::get('fi.mailDefaultCc'))
            ->with('subject', trans('fi.quote') . ' #' . $quote->number)
            ->with('body', Parser::parse($quote, Config::get('fi.quoteEmailBody')));
    }

    /**
     * Attempt to send the mail
     * @return json
     */
    public function mailQuote()
    {
        $pdfPath = '';

        $quote = $this->quote->find(Input::get('quote_id'));

        $quoteMailer = App::make('QuoteMailer');

        // Should the document be attached?
        if (Input::get('attach_pdf') == 'true')
        {
            // Define the path
            $pdfPath = app_path() . '/storage/' . FileNames::quote($quote);

            // Save the file
            $pdf = PDFFactory::create();

            $pdf->save($quote->html, $pdfPath);
        }

        if (!$quoteMailer->send($quote, Input::get('to'), Input::get('subject'), Input::get('body'), Input::get('cc'), $pdfPath))
        {
            // Delete the document
            if ($pdfPath and file_exists($pdfPath))
            {
                unlink($pdfPath);
            }

            return Response::json(array(
                'success' => false,
                'errors'  => array(array($quoteMailer->errors()))
            ), 400);
        }

        // Delete the document
        if ($pdfPath and file_exists($pdfPath))
        {
            unlink($pdfPath);
        }
    }

    /**
     * Creates PDF for download
     * @param  int $id
     * @return pdf
     */
    public function pdf($id)
    {
        $quote = $this->quote->find($id);

        $pdf = PDFFactory::create();

        $pdf->download($quote->html, FileNames::quote($quote));
    }

}