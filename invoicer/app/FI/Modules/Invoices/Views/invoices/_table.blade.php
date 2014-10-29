<table class="table table-hover">

	<thead>
		<tr>
			<th>{{ trans('fi.status') }}</th>
			<th>{{ trans('fi.invoice') }}</th>
            <th>{{ trans('fi.created') }}</th>
			<th>{{ trans('fi.due_date') }}</th>
			<th>{{ trans('fi.client_name') }}</th>
			<th style="text-align: right; padding-right: 25px;">{{ trans('fi.amount') }}</th>
			<th style="text-align: right; padding-right: 25px;">{{ trans('fi.balance') }}</th>
			<th>{{ trans('fi.options') }}</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($invoices as $invoice)
		<tr>
			<td>
                <span class="label label-{{ $statuses[$invoice->invoice_status_id] }}">{{ trans('fi.' . $statuses[$invoice->invoice_status_id]) }}</span>
				@if ($invoice->viewed) 
				<span class="label label-success">{{ trans('fi.viewed') }}</span>
				@else
				<span class="label label-default">{{ trans('fi.not_viewed') }}</span>
				@endif
			</td>
			<td><a href="{{ route('invoices.edit', array($invoice->id)) }}" title="{{ trans('fi.edit') }}">{{{ $invoice->number }}}</a></td>
            <td>{{ $invoice->formatted_created_at }}</td>
			<td @if ($invoice->isOverdue) style="color: red; font-weight: bold;" @endif>{{ $invoice->formatted_due_at }}</td>
			<td><a href="{{ route('clients.show', array($invoice->client->id)) }}" title="{{ trans('fi.view_client') }}">{{{ $invoice->client->name }}}</a></td>
			<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_total }}</td>
			<td style="text-align: right; padding-right: 25px;">{{ $invoice->amount->formatted_balance }}</td>
			<td>
				<div class="btn-group">
					<a href="{{ route('invoices.edit', array($invoice->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
					<a href="{{ route('invoices.pdf', array($invoice->id)) }}" target="_blank" id="btn-pdf-invoice" class="btn btn-sm btn-default" title="{{ trans('fi.pdf') }}"><i class="fa fa-print"></i></a>
					@if ($mailConfigured)
					<a href="javascript:void(0)" class="btn btn-sm btn-default email-invoice" data-invoice-id="{{ $invoice->id }}" data-redirect-to="{{ Request::fullUrl() }}" title="{{ trans('fi.email') }}"><i class="fa fa-envelope"></i></a> 
					@endif
                    <a href="{{ route('clientCenter.invoice.show', array($invoice->url_key)) }}" target="_blank" id="btn-public-invoice" class="btn btn-sm btn-default" title="{{ trans('fi.public') }}"><i class="fa fa-globe"></i></a>
					<a href="javascript:void(0)" id="btn-enter-payment" class="btn btn-sm btn-default enter-payment" data-invoice-id="{{ $invoice->id }}" data-invoice-balance="{{ $invoice->amount->formatted_numeric_balance }}" data-redirect-to="{{ Request::fullUrl() }}" title="{{ trans('fi.enter_payment') }}"><i class="fa fa-credit-card"></i></a>
					<a href="{{ route('invoices.delete', array($invoice->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
				</div>

			</td>
		</tr>
		@endforeach
	</tbody>

</table>