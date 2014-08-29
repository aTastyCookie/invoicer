@extends('layouts.master')

@section('jscript')

<script type="text/javascript">

	var itemLookupRoute       = '{{ route('itemLookups.ajax.itemLookup') }}';
	var itemCount             = {{ count($invoice->items) }};
	var addTaxModalRoute      = '{{ route('invoices.ajax.modalAddInvoiceTax') }}';
	var copyInvoiceModalRoute = '{{ route('invoices.ajax.modalCopyInvoice') }}';
	var invoiceEditRoute      = '{{ route('invoices.edit', array($invoice->id)) }}';
	var invoiceUpdateRoute    = '{{ route('invoices.update', array($invoice->id)) }}';
	var invoiceId             = {{ $invoice->id }};
	var clientId              = {{ $invoice->client_id }};

</script>

@include('layouts._datemask')
@include('layouts._typeahead')

<script src="{{ asset('js/FI/item_lookups.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/FI/invoice_edit.js') }}" type="text/javascript"></script>

@stop

@section('content')

<aside class="right-side">

	<section class="content-header">
		<h1 class="pull-left">{{ trans('fi.invoice') }} #{{ $invoice->number }}</h1>

		@if ($invoice->viewed)
		<span style="margin-left: 10px;" class="label label-success">{{ trans('fi.viewed') }}</span>
		@else
		<span style="margin-left: 10px;" class="label label-default">{{ trans('fi.not_viewed') }}</span>
		@endif

		<div class="pull-right">
			<a href="{{ route('invoices.pdf', array($invoice->id)) }}" target="_blank" id="btn-pdf-invoice" class="btn btn-default"><i class="fa fa-print"></i> {{ trans('fi.pdf') }}</a>
			@if ($mailConfigured)
			<a href="javascript:void(0)" id="btn-email-invoice" class="btn btn-default email-invoice" data-invoice-id="{{ $invoice->id }}" data-redirect-to="{{ Request::url() }}"><i class="fa fa-envelope"></i> {{ trans('fi.email') }}</a>
			@endif

			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					{{ trans('fi.other') }} <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="javascript:void(0)" id="btn-enter-payment" class="enter-payment" data-invoice-id="{{ $invoice->id }}" data-invoice-balance="{{ $invoice->amount->formatted_numeric_balance }}" data-redirect-to="{{ Request::url() }}"><i class="fa fa-credit-card"></i> {{ trans('fi.enter_payment') }}</a></li>
					<li><a href="javascript:void(0)" id="btn-copy-invoice"><i class="fa fa-copy"></i> {{ trans('fi.copy_invoice') }}</a></li>
					<li><a href="{{ route('clientCenter.invoice.show', array($invoice->url_key)) }}" target="_blank"><i class="fa fa-globe"></i> {{ trans('fi.public') }}</a></li>
				</ul>
			</div>

			<div class="btn-group">
				@if ($backPath)
				<a href="{{ URL::to($backPath) }}" class="btn btn-default"><i class="fa fa-backward"></i> {{ trans('fi.back') }}</a>
				@endif
				<a href="javascript:void(0)" id="btn-save-invoice" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('fi.save') }}</a>
			</div>
		</div>

		<div class="clearfix"></div>
	</section>

	<section class="content invoice">

		@include('layouts._alerts')

		<div id="form-status-placeholder"></div>

		<div class="row invoice-info">
			<div class="col-sm-4 invoice-col">
				{{ trans('fi.from') }}
				<address>
					@if ($invoice->user->company) <strong>{{ $invoice->user->company }}</strong><br> @endif
					{{ $invoice->user->name }}<br>
					{{ $invoice->user->formatted_address }}<br>
					{{ trans('fi.phone') }}: {{ $invoice->user->phone }}<br>
					{{ trans('fi.email') }}: {{ $invoice->user->email }}
				</address>
			</div>
			<div class="col-sm-4 invoice-col">
				{{ trans('fi.to') }}
				<address>
					<strong>{{ $invoice->client->name }}</strong><br>
					{{ $invoice->client->formatted_address }}<br>
					{{ trans('fi.phone') }}: {{ $invoice->client->phone }}<br>
					{{ trans('fi.email') }}: {{ $invoice->client->email }}
				</address>
			</div>
			<div class="col-sm-4 invoice-col">
				<span class="pull-left"><b>{{ trans('fi.invoice') }} #</b></span><span class="pull-right">{{ Form::text('number', $invoice->number, array('id' => 'number', 'class' => 'form-control input-sm')) }}</span>
				<div class="clearfix"></div>
				<span class="pull-left"><b>{{ trans('fi.date') }}</b></span><span class="pull-right">{{ Form::text('created_at', $invoice->formatted_created_at, array('id' => 'created_at', 'class' => 'form-control input-sm')) }}</span><br>
				<div class="clearfix"></div>
				<span class="pull-left"><b>{{ trans('fi.due_date') }}</b></span><span class="pull-right">{{ Form::text('due_at', $invoice->formatted_due_at, array('id' => 'due_at', 'class' => 'form-control input-sm')) }}</span><br>
				<div class="clearfix"></div>
				<span class="pull-left"><b>{{ trans('fi.status') }}</b></span><span class="pull-right">{{ Form::select('invoice_status_id', $statuses, $invoice->invoice_status_id, array('id' => 'invoice_status_id', 'class' => 'form-control input-sm')) }}</span>
				<div class="clearfix"></div>
				<span class="pull-left"><b>{{ trans('fi.currency') }}</b></span><span class="pull-right">{{ Form::select('currency_code', $currencies, $invoice->currency_code, array('id' => 'currency_code', 'class' => 'form-control input-sm')) }}</span>
				<div class="clearfix"></div>
				<span class="pull-left"><b>{{ trans('fi.exchange_rate') }}</b></span><span class="pull-right">{{ Form::text('exchange_rate', $invoice->exchange_rate, array('id' => 'exchange_rate', 'class' => 'form-control input-sm')) }}</span><br>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="row">

			<div class="col-xs-12 table-responsive">

				<a href="javascript:void(0)" id="btn-add-item" class="btn btn-default"><i class="fa fa-plus"></i> {{ trans('fi.add_item') }}</a>

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
								{{ Form::hidden('invoice_id', $invoice->id) }}
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
						@foreach ($invoice->items as $item)
						<tr class="item">
							<td>
								{{ Form::hidden('invoice_id', $invoice->id) }}
								{{ Form::hidden('item_id', $item->id) }}
								{{ Form::text('item_name', $item->name, array('class' => 'form-control item-lookup')) }}
							</td>
							<td>{{ Form::textarea('item_description', $item->description, array('class' => 'form-control', 'rows' => 1)) }}</td>
							<td>{{ Form::text('item_quantity', $item->formatted_quantity, array('class' => 'form-control')) }}</td>
							<td>{{ Form::text('item_price', $item->formatted_numeric_price, array('class' => 'form-control')) }}</td>
							<td>{{ Form::select('item_tax_rate_id', $taxRates, $item->tax_rate_id, array('class' => 'form-control')) }}</td>
							<td style="text-align: right; padding-right: 25px;">{{ $item->amount->formatted_subtotal }}</td>
							<td>
								<a class="btn btn-xs btn-default" href="{{ route('invoices.items.delete', array($invoice->id, $item->id)) }}" title="{{ trans('fi.delete') }}">
									<i class="fa fa-times"></i>
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</div>

		<div class="row">
			
			<div class="col-xs-4">
				<a href="javascript:void(0)" id="btn-add-tax" class="btn btn-default"><i class="fa fa-plus-square"></i> {{ trans('fi.add_tax') }}</a>
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
						@foreach ($invoice->taxRates as $invoiceTax)
						<tr>
							<td>{{ $invoiceTax->taxRate->name }}</td>
							<td>{{ $invoiceTax->taxRate->formatted_percent }}</td>
							<td>{{ $invoiceTax->formatted_tax_total }}</td>
							<td>
								<a class="btn btn-xs btn-default" href="{{ route('invoices.ajax.deleteInvoiceTax', array($invoice->id, $invoiceTax->id)) }}">
									<i class="fa fa-times"></i>
								</a>
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="col-xs-4">

			</div>

			<div class="col-xs-4">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th style="width: 70%; text-align: right;">{{ trans('fi.subtotal') }}:</th>
								<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_item_subtotal }}</td>
							</tr>

							<tr>
								<th style="width: 70%; text-align: right;">{{ trans('fi.tax') }}:</th>
								<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_total_tax }}</td>
							</tr>

							<tr>
								<th style="text-align: right;">{{ trans('fi.total') }}:</th>
								<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_total }} @if ($invoice->is_foreign_currency) ({{ $invoice->amount->formatted_converted_total }}) @endif</td>
							</tr>
							<tr>
								<th style="text-align: right;">{{ trans('fi.paid') }}:</th>
								<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_paid }} @if ($invoice->is_foreign_currency) ({{ $invoice->amount->formatted_converted_paid }}) @endif</td>
							</tr>
							<tr>
								<th style="text-align: right;">{{ trans('fi.balance') }}:</th>
								<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_balance }} @if ($invoice->is_foreign_currency) ({{ $invoice->amount->formatted_converted_balance }}) @endif</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-xs-6">
				<label>{{ trans('fi.terms_and_conditions') }}</label>
				{{ Form::textarea('terms', $invoice->terms, array('id' => 'terms', 'class' => 'form-control', 'rows' => 2)) }}
			</div>

			<div class="col-xs-6">
				<label>{{ trans('fi.footer') }}</label>
				{{ Form::textarea('footer', $invoice->footer, array('id' => 'footer', 'class' => 'form-control', 'rows' => 2)) }}
			</div>

		</div>

		@if ($customFields->count())
		<br>
		<div class="row">
			<div class="col-lg-12">
				@include('custom_fields._custom_fields_unbound', array('object' => $invoice))
			</div>
		</div>
		@endif

	</section>

</aside>

@stop