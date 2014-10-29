<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{{ trans('fi.invoice') }}} #{{{ $invoice->number }}}</title>

	<style>
		* {
			margin:0px;
		}
		body { 
			font-family: sans-serif;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 20px;
            padding-right: 20px;
		}
		table {
			width: 100%;
			border-collapse: collapse;
		}

		td, th {
			vertical-align: top;
			padding-left: 5px;
			padding-right: 5px;
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.footer { 
			position: fixed; 
			bottom: 100px;
			margin-left: 75px;
			margin-right: 75px;
			text-align: center;
		}

		.border-top {
			border-top: 1px dotted #000000;
		}

		.border-bottom {
			border-bottom: 1px dotted #000000;
		}

		.invoice-table {
			font-size: 80%;
		}

		.invoice-table td {
			padding-top: 5px;
		}
	</style>
</head>
<body>

	<table>
		<tr>
			<td class="border-bottom" style="width: 50%;">
				{{{ $logo }}}
			</td>
			<td class="border-bottom" style="width: 50%; text-align: right;">
				<h1 style="margin: 0;">{{{ trans('fi.invoice') }}}</h1>
				{{{ trans('fi.invoice') }}} #{{{ $invoice->number }}}<br>
				{{{ trans('fi.issued') }}} {{{ $invoice->formatted_created_at }}}<br>
				{{{ trans('fi.due') }}} {{{ $invoice->formatted_due_at }}}
			</td>
		</tr>
	</table>

	<table style="margin-top: 20px; margin-bottom: 20px;">
		<tr>
			<td style="width: 50%;">
				<strong>{{{ trans('fi.from') }}}:</strong><br>
				@if ($invoice->user->company) {{{ $invoice->user->company }}}<br> @endif
				{{{ $invoice->user->name }}}<br>
				{{{ $invoice->user->formatted_address }}}<br>
				{{{ $invoice->user->email }}}<br>
				{{{ $invoice->user->phone }}}
			</td>
			<td style="width: 50%;">
				<strong>{{{ trans('fi.to') }}}:</strong><br>
				{{{ $invoice->client->name }}}<br>
				{{{ $invoice->client->formatted_address }}}<br>
				{{{ $invoice->client->email }}}<br>
				{{{ $invoice->client->phone }}}
			</td>
		</tr>
	</table>

	<table class="invoice-table">
		<thead>
			<tr style="background-color: #e8e8e8;">
				<th class="border-top">{{{ trans('fi.product') }}}</th>
				<th class="border-top">{{{ trans('fi.description') }}}</th>
				<th class="border-top text-right">{{{ trans('fi.quantity') }}}</th>
				<th class="border-top text-right">{{{ trans('fi.price') }}}</th>
				<th class="border-top text-right">{{{ trans('fi.tax') }}}</th>
				<th class="border-top text-right">{{{ trans('fi.total') }}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($invoice->items as $item)
			<tr>
				<td>{{{ $item->name }}}</td>
				<td>{{{ $item->formatted_description }}}</td>
				<td class="text-right">{{{ $item->formatted_quantity }}}</td>
				<td class="text-right">{{{ $item->formatted_price }}}</td>
				<td class="text-right">{{{ $item->amount->formatted_tax_total }}}</td>
				<td class="text-right">{{{ $item->amount->formatted_total }}}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="6"></td>
			</tr>
			<tr>
				<td colspan="5" class="border-top text-right">{{{ trans('fi.subtotal') }}}</td>
				<td class="border-top text-right">{{{ $invoice->amount->formatted_item_total }}}</td>
			</tr>
			@foreach ($invoice->taxRates as $invoiceTaxRate)
			<tr>
				<td colspan="5" class="text-right">{{{ $invoiceTaxRate->taxRate->name }}} {{{ $invoiceTaxRate->taxRate->formatted_percent }}}</td>
				<td class="text-right">{{{ $invoiceTaxRate->formatted_tax_total }}}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="5" class="text-right">{{{ trans('fi.total') }}}</td>
				<td class="text-right">{{{ $invoice->amount->formatted_total }}}</td>
			</tr>
			<tr>
				<td colspan="5" class="text-right">{{{ trans('fi.paid') }}}</td>
				<td class="text-right">{{{ $invoice->amount->formatted_paid }}}</td>
			</tr>
			<tr>
				<td colspan="5" class="text-right">{{{ trans('fi.balance') }}}</td>
				<td class="text-right">{{{ $invoice->amount->formatted_balance }}}</td>
			</tr>
		</tbody>

	</table>

	@if ($invoice->terms)
	<strong>{{{ trans('fi.terms_and_conditions') }}}</strong>
	<p>{{{ $invoice->formatted_terms }}}</p>
	@endif

	<div class="footer">{{{ $invoice->formatted_footer }}}</div>

</body>
</html>