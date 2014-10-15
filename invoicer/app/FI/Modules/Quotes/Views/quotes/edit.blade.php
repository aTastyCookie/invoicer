@extends('layouts.master')

@section('jscript')

<script type="text/javascript">

	var itemLookupRoute       = '{{ route('itemLookups.ajax.itemLookup') }}';
	var itemCount             = {{ count($quote->items) }};
	var addTaxModalRoute      = '{{ route('quotes.ajax.modalAddQuoteTax') }}';
	var copyQuoteModalRoute   = '{{ route('quotes.ajax.modalCopyQuote') }}';
	var quoteToInvoiceRoute   = '{{ route('quotes.ajax.modalQuoteToInvoice') }}';
	var quoteEditRoute        = '{{ route('quotes.edit', array($quote->id)) }}';
	var quoteUpdateRoute      = '{{ route('quotes.update', array($quote->id)) }}';
	var quoteId               = {{ $quote->id }};
	var clientId              = {{ $quote->client_id }};
    var getExchangeRateRoute  = '{{ route('currencies.getExchangeRate') }}';

</script>

@include('layouts._datemask')
@include('layouts._typeahead')

<script src="{{ asset('js/plugins/jquery-autosize.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/FI/item_lookups.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/FI/quote_edit.js') }}" type="text/javascript"></script>

@stop

@section('content')

<aside class="right-side">

    <section class="content-header">
        <h1 class="pull-left">{{ trans('fi.quote') }} #{{ $quote->number }}</h1>
    
        @if ($quote->viewed)
        <span style="margin-left: 10px;" class="label label-success">{{ trans('fi.viewed') }}</span>
        @else
        <span style="margin-left: 10px;" class="label label-default">{{ trans('fi.not_viewed') }}</span>
        @endif
    
        <div class="pull-right">
    
            <a href="{{ route('quotes.pdf', array($quote->id)) }}" target="_blank" id="btn-pdf-quote" class="btn btn-default"><i class="fa fa-print"></i> {{ trans('fi.pdf') }}</a>
            @if ($mailConfigured)
            <a href="javascript:void(0)" id="btn-email-quote" class="btn btn-default email-quote" data-quote-id="{{ $quote->id }}" data-redirect-to="{{ Request::url() }}"><i class="fa fa-envelope"></i> {{ trans('fi.email') }}</a>
            @endif
    
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    {{ trans('fi.other') }} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:void(0)" id="btn-copy-quote"><i class="fa fa-copy"></i> {{ trans('fi.copy_quote') }}</a></li>
                    <li><a href="javascript:void(0)" id="btn-quote-to-invoice"><i class="fa fa-check"></i> {{ trans('fi.quote_to_invoice') }}</a></li>
                    <li><a href="{{ route('clientCenter.quote.show', array($quote->url_key)) }}" target="_blank"><i class="fa fa-globe"></i> {{ trans('fi.public') }}</a></li>
                </ul>
            </div>
    
            <div class="btn-group">
                @if ($backPath)
                <a href="{{ URL::to($backPath) }}" class="btn btn-default"><i class="fa fa-backward"></i> {{ trans('fi.back') }}</a>
                @endif
            </div>
    
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-save-quote"><i class="fa fa-save"></i> {{ trans('fi.save') }}</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" class="btn-save-quote" data-apply-exchange-rate="1">{{ trans('fi.save_and_apply_exchange_rate') }}</a></li>
                </ul>
            </div>
    
        </div>
    
        <div class="clearfix"></div>
    </section>
    
    <section class="content">
    
    <div class="row">
    
        <div class="col-lg-10">
        
            @include('layouts._alerts')
        
            <div id="form-status-placeholder"></div>
        
            <div class="row equal">
        
                <div class="col-sm-6">
        
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('fi.from') }}</h3>
                        </div>
                        <div class="box-body">
                            @if ($quote->user->company) <strong>{{ $quote->user->company }}</strong><br> @endif
                            {{ $quote->user->name }}<br>
                            {{ $quote->user->formatted_address }}<br>
                            {{ trans('fi.phone') }}: {{ $quote->user->phone }}<br>
                            {{ trans('fi.email') }}: {{ $quote->user->email }}
                        </div>
                    </div>
        
                </div>
        
                <div class="col-sm-6">
        
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('fi.to') }}</h3>
                        </div>
                        <div class="box-body">
                            <strong>
                                <a href="{{ route('clients.show', array($quote->client_id)) }}">
                                    {{ $quote->client->name }}
                                </a>
                            </strong><br>
                            {{ $quote->client->formatted_address }}<br>
                            {{ trans('fi.phone') }}: {{ $quote->client->phone }}<br>
                            {{ trans('fi.email') }}: {{ $quote->client->email }}
                        </div>
                    </div>
        
                </div>
        
            </div>
        
            <div class="row">
        
                <div class="col-sm-12 table-responsive">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('fi.items') }}</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-primary btn-sm" id="btn-add-item"><i class="fa fa-plus"></i> {{ trans('fi.add_item') }}</button>
                            </div>
                        </div>
        
                        <div class="box-body">
                            <table id="item-table" class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">{{ trans('fi.product') }}</th>
                                    <th style="width: 25%;">{{ trans('fi.description') }}</th>
                                    <th style="width: 10%;">{{ trans('fi.qty') }}</th>
                                    <th style="width: 10%;">{{ trans('fi.price') }}</th>
                                    <th style="width: 10%;">{{ trans('fi.tax_rate') }}</th>
                                    <th style="width: 10%; text-align: right; padding-right: 25px;">{{ trans('fi.total') }}</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="new-item" style="display: none;">
                                    <td>
                                        {{ Form::hidden('quote_id', $quote->id) }}
                                        {{ Form::hidden('item_id', '') }}
                                        {{ Form::text('item_name', null, array('class' => 'form-control')) }}<br>
                                        <label><input type="checkbox" name="save_item_as_lookup" class="form-control" tabindex="999"> {{ trans('fi.save_item_as_lookup') }}</label>
                                    </td>
                                    <td>{{ Form::textarea('item_description', null, array('class' => 'form-control', 'rows' => 1)) }}</td>
                                    <td>{{ Form::text('item_quantity', null, array('class' => 'form-control')) }}</td>
                                    <td>{{ Form::text('item_price', null, array('class' => 'form-control')) }}</td>
                                    <td>{{ Form::select('item_tax_rate_id', $taxRates, Config::get('fi.itemTaxRate'), array('class' => 'form-control')) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($quote->items as $item)
                                <tr class="item">
                                    <td>
                                        {{ Form::hidden('quote_id', $quote->id) }}
                                        {{ Form::hidden('item_id', $item->id) }}
                                        {{ Form::text('item_name', $item->name, array('class' => 'form-control item-lookup')) }}
                                    </td>
                                    <td>{{ Form::textarea('item_description', $item->description, array('class' => 'form-control', 'rows' => 1)) }}</td>
                                    <td>{{ Form::text('item_quantity', $item->formatted_quantity, array('class' => 'form-control')) }}</td>
                                    <td>{{ Form::text('item_price', $item->formatted_numeric_price, array('class' => 'form-control')) }}</td>
                                    <td>{{ Form::select('item_tax_rate_id', $taxRates, $item->tax_rate_id, array('class' => 'form-control')) }}</td>
                                    <td style="text-align: right; padding-right: 25px;">{{ $item->amount->formatted_subtotal }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default" href="{{ route('quotes.items.delete', array($quote->id, $item->id)) }}" title="{{ trans('fi.delete') }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
        
                    </div>
                </div>
        
            </div>
        
            <div class="row">
        
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('fi.taxes') }}</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-primary btn-sm" id="btn-add-tax"><i class="fa fa-plus"></i> {{ trans('fi.add_tax') }}</button>
                            </div>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ trans('fi.tax') }}</th>
                                    <th>{{ trans('fi.percent') }}</th>
                                    <th>{{ trans('fi.total') }}</th>
                                    <th>{{ trans('fi.delete') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($quote->taxRates as $quoteTax)
                                <tr>
                                    <td>{{ $quoteTax->taxRate->name }}</td>
                                    <td>{{ $quoteTax->taxRate->formatted_percent }}</td>
                                    <td>{{ $quoteTax->formatted_tax_total }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-default" href="{{ route('quotes.ajax.deleteQuoteTax', array($quote->id, $quoteTax->id)) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('fi.terms_and_conditions') }}</h3>
                        </div>
                        <div class="box-body">
                            {{ Form::textarea('terms', $quote->terms, array('id' => 'terms', 'class' => 'form-control', 'rows' => 5)) }}
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('fi.footer') }}</h3>
                        </div>
                        <div class="box-body">
                            {{ Form::textarea('footer', $quote->footer, array('id' => 'footer', 'class' => 'form-control', 'rows' => 5)) }}
                        </div>
                    </div>
                </div>
        
            </div>
        
        </div>
    
        <div class="col-lg-2">
        
            <div class="box box-primary">
                <div class="box-body">
                    <span class="pull-left"><strong>{{ trans('fi.subtotal') }}</strong></span><span class="pull-right">{{ $quote->amount->formatted_item_subtotal }}</span>
                    <div class="clearfix"></div>
                    <span class="pull-left"><strong>{{ trans('fi.tax') }}</strong></span><span class="pull-right">{{ $quote->amount->formatted_total_tax }}</span>
                    <div class="clearfix"></div>
                    <span class="pull-left"><strong>{{ trans('fi.total') }}</strong></span><span class="pull-right">{{ $quote->amount->formatted_total }}</span>
                    <div class="clearfix"></div>
                </div>
            </div>
        
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('fi.options') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('fi.quote') }} #</label>
                        {{ Form::text('number', $quote->number, array('id' => 'number', 'class' =>
                        'form-control
                        input-sm')) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('fi.date') }}</label>
                        {{ Form::text('created_at', $quote->formatted_created_at, array('id' =>
                        'created_at', 'class' => 'form-control input-sm')) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('fi.expires_at') }}</label>
                        {{ Form::text('expires_at', $quote->formatted_expires_at, array('id' => 'expires_at', 'class'
                        => 'form-control input-sm')) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('fi.currency') }}</label>
                        {{ Form::select('currency_code', $currencies, $quote->currency_code, array('id' =>
                        'currency_code', 'class' => 'form-control input-sm')) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('fi.exchange_rate') }}</label>
                        <div class="input-group">
                            {{ Form::text('exchange_rate', $quote->exchange_rate, array('id' =>
                            'exchange_rate', 'class' => 'form-control input-sm')) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-sm" id="btn-update-exchange-rate" type="button"
                                        data-toggle="tooltip" data-placement="left"
                                        title="{{ trans('fi.update_exchange_rate') }}"><i class="fa fa-refresh"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('fi.status') }}</label>
                        {{ Form::select('quote_status_id', $statuses, $quote->quote_status_id,
                        array('id' => 'quote_status_id', 'class' => 'form-control input-sm')) }}
                    </div>
                    <div class="form-group">
                        <label>{{ trans('fi.template') }}</label>
                        {{ Form::select('template', $templates, $quote->template,
                        array('id' => 'template', 'class' => 'form-control input-sm')) }}
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    
    @if ($customFields->count())
    <div class="row">
        <div class="col-md-12">
            @include('custom_fields._custom_fields_unbound', array('object' => $quote))
        </div>
    </div>
    @endif
    
    </section>

</aside>

@stop