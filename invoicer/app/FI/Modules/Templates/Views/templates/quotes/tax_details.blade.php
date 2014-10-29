<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{{ trans('fi.quote') }} #{{{ $quote->number }}</title>

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
				{{{ $logo }}
			</td>
			<td class="border-bottom" style="width: 50%; text-align: right;">
				<h1 style="margin: 0;">{{{ trans('fi.quote') }}</h1>
				{{{ trans('fi.quote') }} #{{{ $quote->number }}<br>
				{{{ trans('fi.issued') }} {{{ $quote->formatted_created_at }}<br>
				{{{ trans('fi.expires') }} {{{ $quote->formatted_expires_at }}
			</td>
		</tr>
	</table>

	<table style="margin-top: 20px; margin-bottom: 20px;">
		<tr>
			<td style="width: 50%;">
				<strong>{{{ trans('fi.from') }}:</strong><br>
				@if ($quote->user->company) {{{ $quote->user->company }}<br> @endif
				{{{ $quote->user->name }}<br>
				{{{ $quote->user->formatted_address }}<br>
				{{{ $quote->user->email }}<br>
				{{{ $quote->user->phone }}
			</td>
			<td style="width: 50%;">
				<strong>{{{ trans('fi.to') }}:</strong><br>
				{{{ $quote->client->name }}<br>
				{{{ $quote->client->formatted_address }}<br>
				{{{ $quote->client->email }}<br>
				{{{ $quote->client->phone }}
			</td>
		</tr>
	</table>

	<table class="invoice-table">
		<thead>
			<tr style="background-color: #e8e8e8;">
				<th class="border-top">{{{ trans('fi.product') }}</th>
				<th class="border-top">{{{ trans('fi.description') }}</th>
				<th class="border-top text-right">{{{ trans('fi.quantity') }}</th>
				<th class="border-top text-right">{{{ trans('fi.price') }}</th>
				<th class="border-top text-right">{{{ trans('fi.tax') }}</th>
				<th class="border-top text-right">{{{ trans('fi.total') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($quote->items as $item)
			<tr>
				<td>{{{ $item->name }}</td>
				<td>{{{ $item->formatted_description }}</td>
				<td class="text-right">{{{ $item->formatted_quantity }}</td>
				<td class="text-right">{{{ $item->formatted_price }}</td>
				<td class="text-right">{{{ $item->amount->formatted_tax_total }}</td>
				<td class="text-right">{{{ $item->amount->formatted_total }}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="6"></td>
			</tr>
			<tr>
				<td colspan="5" class="border-top text-right">{{{ trans('fi.subtotal') }}</td>
				<td class="border-top text-right">{{{ $quote->amount->formatted_item_total }}</td>
			</tr>
			@foreach ($quote->taxRates as $quoteTaxRate)
			<tr>
				<td colspan="5" class="text-right">{{{ $quoteTaxRate->taxRate->name }} {{{ $quoteTaxRate->taxRate->formatted_percent }}</td>
				<td class="text-right">{{{ $quoteTaxRate->formatted_tax_total }}</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="5" class="text-right">{{{ trans('fi.total') }}</td>
				<td class="text-right">{{{ $quote->amount->formatted_total }}</td>
			</tr>
		</tbody>

	</table>

	@if ($quote->terms)
	<strong>{{{ trans('fi.terms_and_conditions') }}</strong>
	<p>{{{ $quote->formatted_terms }}</p>
	@endif

	<div class="footer">{{{ $quote->formatted_footer }}</div>

</body>
</html>