<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Controllers;

use App;
use Auth;
use Config;
use Event;
use FI\Libraries\BackPath;
use FI\Libraries\DateFormatter;
use FI\Libraries\Frequency;
use FI\Libraries\HTML;
use FI\Libraries\InvoiceTemplates;
use FI\Libraries\NumberFormatter;
use FI\Libraries\Parser;
use FI\Libraries\PDF;
use FI\Statuses\InvoiceStatuses;
use Input;
use Redirect;
use Response;
use Session;
use View;

class InvoiceController extends \BaseController {

    /**
     * Invoice repository
     * @var InvoiceRepository
     */
    protected $invoice;

    /**
     * Invoice group repository
     * @var InvoiceGroupRepository
     */
    protected $invoiceGroup;

    /**
     * Invoice item repository
     * @var InvoiceItemRepository
     */
    protected $invoiceItem;

    /**
     * Invoice tax rate repository
     * @var InvoiceTaxRateRepository
     */
    protected $invoiceTaxRate;

    /**
     * Invoice validator
     * @var InvoiceValidator
     */
    protected $validator;

    /**
     * Dependency injection
     * @param InvoiceRepository $invoice
     * @param InvoiceGroupRepository $invoiceGroup
     * @param InvoiceItemRepository $invoiceItem
     * @param InvoiceTaxRateRepository $invoiceTaxRate
     * @param InvoiceValidator $validator
     */
    public function __construct($invoice, $invoiceGroup, $invoiceItem, $invoiceTaxRate, $validator)
    {
        parent::__construct();

        $this->invoice        = $invoice;
        $this->invoiceGroup   = $invoiceGroup;
        $this->invoiceItem    = $invoiceItem;
        $this->invoiceTaxRate = $invoiceTaxRate;
        $this->validator      = $validator;
    }

    /**
     * Display paginated list
     * @return View
     */
    public function index()
    {
        $status = (Input::get('status')) ?: 'all';

        $invoices = $this->invoice->getPagedByStatus($status, Input::get('search'), Input::get('client'));
        $statuses = InvoiceStatuses::statuses();

        return View::make('invoices.index')
            ->with('invoices', $invoices)
            ->with('status', $status)
            ->with('statuses', $statuses)
            ->with('filterRoute', route('invoices.index', array($status)));
    }

    /**
     * Accept post data to create invoice
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

        $invoiceClient = $client->firstOrCreate(Input::get('client_name'));

        $input = array(
            'client_id'         => $invoiceClient->id,
            'created_at'        => DateFormatter::unformat(Input::get('created_at')),
            'due_at'            => DateFormatter::incrementDateByDays(DateFormatter::unformat(Input::get('created_at')), Config::get('fi.invoicesDueAfter')),
            'invoice_group_id'  => Input::get('invoice_group_id'),
            'number'            => $this->invoiceGroup->generateNumber(Input::get('invoice_group_id')),
            'user_id'           => Auth::user()->id,
            'invoice_status_id' => 1,
            'url_key'           => str_random(32),
            'terms'             => Config::get('fi.invoiceTerms'),
            'footer'            => Config::get('fi.invoiceFooter'),
            'currency_code'     => $invoiceClient->currency_code,
            'exchange_rate'     => '',
            'template'          => $invoiceClient->invoice_template
        );

        $invoiceId = $this->invoice->create($input)->id;

        if (Input::get('recurring'))
        {
            $recurringInvoice = App::make('RecurringInvoiceRepository');

            $recurringInvoice->create(
                array(
                    'invoice_id'          => $invoiceId,
                    'recurring_frequency' => Input::get('recurring_frequency'),
                    'recurring_period'    => Input::get('recurring_period'),
                    'generate_at'         => DateFormatter::incrementDate(DateFormatter::unformat(Input::get('created_at')), Input::get('recurring_period'), Input::get('recurring_frequency'))
                )
            );
        }

        return Response::json(array('success' => true, 'id' => $invoiceId), 200);
    }

    /**
     * Accept post data to update invoice
     * @param  int $id
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

        $invoice = array(
            'number'            => $input['number'],
            'created_at'        => DateFormatter::unformat($input['created_at']),
            'due_at'            => DateFormatter::unformat($input['due_at']),
            'invoice_status_id' => $input['invoice_status_id'],
            'terms'             => $input['terms'],
            'footer'            => $input['footer'],
            'currency_code'     => $input['currency_code'],
            'exchange_rate'     => $input['exchange_rate'],
            'template'          => $input['template']
        );

        $invoice = $this->invoice->update($invoice, $id);

        App::make('InvoiceCustomRepository')->save($custom, $id);

        $items = json_decode(Input::get('items'));

        foreach ($items as $item)
        {
            if ($item->item_name)
            {
                $itemRecord = array(
                    'invoice_id'    => $item->invoice_id,
                    'name'          => $item->item_name,
                    'description'   => $item->item_description,
                    'quantity'      => NumberFormatter::unformat($item->item_quantity),
                    'price'         => ((!Input::get('apply_exchange_rate')) ? NumberFormatter::unformat($item->item_price) : (NumberFormatter::unformat($item->item_price) * Input::get('exchange_rate'))),
                    'tax_rate_id'   => $item->item_tax_rate_id,
                    'display_order' => $item->item_order
                );

                if (!$item->item_id)
                {
                    $this->invoiceItem->create($itemRecord);
                }
                else
                {
                    $this->invoiceItem->update($itemRecord, $item->item_id);
                }

                if (isset($item->save_item_as_lookup) and $item->save_item_as_lookup)
                {
                    $itemLookupRecord = array(
                        'name'        => $item->item_name,
                        'description' => $item->item_description,
                        'price'       => NumberFormatter::unformat($item->item_price)
                    );

                    App::make('ItemLookupRepository')->create($itemLookupRecord);
                }
            }
        }

        Event::fire('invoice.modified', $invoice);

        Session::flash('alertInfo', trans('fi.invoice_successfully_updated'));

        return Response::json(array('success' => true), 200);
    }

    /**
     * Display the invoice
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
        return View::make('invoices.edit')
            ->with('invoice', $this->invoice->find($id))
            ->with('statuses', InvoiceStatuses::lists())
            ->with('currencies', App::make('CurrencyRepository')->lists())
            ->with('taxRates', App::make('TaxRateRepository')->lists())
            ->with('invoiceTaxRates', $this->invoiceTaxRate->findByInvoiceId($id))
            ->with('customFields', App::make('CustomFieldRepository')->getByTable('invoices'))
            ->with('mailConfigured', (Config::get('fi.mailDriver')) ? true : false)
            ->with('backPath', BackPath::getBackPath())
            ->with('templates', InvoiceTemplates::lists());
    }

    /**
     * Delete an item from a invoice
     * @param  int $invoiceId
     * @param  int $itemId
     * @return Redirect
     */
    public function deleteItem($invoiceId, $itemId)
    {
        $this->invoiceItem->delete($itemId);

        return Redirect::route('invoices.edit', array($invoiceId));
    }

    /**
     * Displays create invoice modal from ajax request
     * @return View
     */
    public function modalCreate()
    {
        return View::make('invoices._modal_create')
            ->with('invoiceGroups', $this->invoiceGroup->lists())
            ->with('frequencies', Frequency::lists());
    }

    /**
     * Displays modal to add invoice taxes from ajax request
     * @return View
     */
    public function modalAddInvoiceTax()
    {
        $taxRates = App::make('TaxRateRepository')->lists();

        return View::make('invoices._modal_add_invoice_tax')
            ->with('invoice_id', Input::get('invoice_id'))
            ->with('taxRates', $taxRates)
            ->with('includeItemTax', array('0' => trans('fi.apply_before_item_tax'), '1' => trans('fi.apply_after_item_tax')));
    }

    /**
     * Saves invoice tax from ajax request
     * @return Response
     */
    public function saveInvoiceTax()
    {
        $validator = App::make('InvoiceTaxRateValidator')->getValidator(Input::all());

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        $this->invoiceTaxRate->create(array(
                'invoice_id'       => Input::get('invoice_id'),
                'tax_rate_id'      => Input::get('tax_rate_id'),
                'include_item_tax' => Input::get('include_item_tax')
            )
        );

        return Response::json(array('success' => true), 200);
    }

    /**
     * Deletes invoice tax
     * @param  int $invoiceId
     * @param  int $invoiceTaxRateId
     * @return Redirect
     */
    public function deleteInvoiceTax($invoiceId, $invoiceTaxRateId)
    {
        $this->invoiceTaxRate->delete($invoiceTaxRateId);

        return Redirect::route('invoices.edit', array($invoiceId));
    }

    /**
     * Deletes a invoice
     * @param  int $id
     * @return Redirect
     */
    public function delete($id)
    {
        $this->invoice->delete($id);

        return Redirect::route('invoices.index')
            ->with('alert', trans('fi.record_successfully_deleted'));
    }

    /**
     * Displays modal to copy invoice
     * @return View
     */
    public function modalCopyInvoice()
    {
        $invoice = $this->invoice->find(Input::get('invoice_id'));

        return View::make('invoices._modal_copy_invoice')
            ->with('invoice', $invoice)
            ->with('invoiceGroups', $this->invoiceGroup->lists())
            ->with('created_at', DateFormatter::format())
            ->with('user_id', Auth::user()->id);
    }

    /**
     * Attempt to copy an invoice
     * @return Redirect
     */
    public function copyInvoice()
    {
        $validator = $this->validator->getValidator(Input::all());

        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors'  => $validator->messages()->toArray()
            ), 400);
        }

        $invoiceCopy = App::make('InvoiceCopyRepository');

        $invoiceId = $invoiceCopy->copyInvoice(Input::get('invoice_id'), Input::get('client_name'), DateFormatter::unformat(Input::get('created_at')), DateFormatter::incrementDateByDays(DateFormatter::unformat(Input::get('created_at')), Config::get('fi.invoicesDueAfter')), Input::get('invoice_group_id'), Auth::user()->id)->id;

        return Response::json(array('success' => true, 'id' => $invoiceId), 200);
    }

    /**
     * Display the modal to send mail
     * @return View
     */
    public function modalMailInvoice()
    {
        $invoice = $this->invoice->find(Input::get('invoice_id'));

        $template = ($invoice->is_overdue) ? Config::get('fi.overdueInvoiceEmailBody') : Config::get('fi.invoiceEmailBody');

        return View::make('invoices._modal_mail')
            ->with('invoiceId', $invoice->id)
            ->with('redirectTo', Input::get('redirectTo'))
            ->with('to', $invoice->client->email)
            ->with('cc', Config::get('fi.mailCcDefault'))
            ->with('subject', trans('fi.invoice') . ' #' . $invoice->number)
            ->with('body', Parser::parse($invoice, $template));
    }

    /**
     * Attempt to send the mail
     * @return json
     */
    public function mailInvoice()
    {
        $invoice = $this->invoice->find(Input::get('invoice_id'));

        $invoiceMailer = App::make('InvoiceMailer');

        if (!$invoiceMailer->send($invoice, Input::get('to'), Input::get('subject'), Input::get('body'), Input::get('cc'), (Input::get('attach_pdf') == 'true') ? true : false))
        {
            return Response::json(array(
                'success' => false,
                'errors'  => array(array($invoiceMailer->errors()))
            ), 400);
        }
    }

    /**
     * Creates PDF for download
     * @param  int $id
     * @return pdf
     */
    public function pdf($id)
    {
        $invoice = $this->invoice->find($id);

        $html = HTML::invoice($invoice);

        $pdf = new PDF($html);
        $pdf->download(trans('fi.invoice') . '_' . $invoice->number . '.pdf');
    }

}