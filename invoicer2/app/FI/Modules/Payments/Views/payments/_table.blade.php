<table class="table table-hover">

	<thead>
		<tr>
			<th>{{ trans('fi.payment_date') }}</th>
            <th>{{ trans('fi.invoice_date') }}</th>
			<th>{{ trans('fi.invoice') }}</th>
            <th>{{ trans('fi.client') }}</th>
			<th>{{ trans('fi.amount') }}</th>
			<th>{{ trans('fi.payment_method') }}</th>
			<th>{{ trans('fi.note') }}</th>
			<th>{{ trans('fi.options') }}</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($payments as $payment)
		<tr>
			<td>{{ $payment->formatted_paid_at }}</td>
            <td>{{ $payment->invoice->formatted_created_at }}</td>
			<td>{{{ $payment->invoice->number }}}</td>
            <td>{{{ $payment->invoice->client->name }}}</td>
			<td>{{ $payment->formatted_amount }}</td>
			<td>@if ($payment->paymentMethod) {{{ $payment->paymentMethod->name }}} @endif</td>
			<td>{{{ $payment->note }}}</td>
			<td>
				<div class="btn-group">
					<a href="{{ route('payments.edit', array($payment->id, $payment->invoice_id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a>
                    @if ($mailConfigured)
                    <a href="javascript:void(0)" class="btn btn-sm btn-default email-payment-receipt" data-payment-id="{{ $payment->id }}" data-redirect-to="{{ Request::fullUrl() }}" title="{{ trans('fi.email_payment_receipt') }}"><i class="fa fa-envelope"></i></a>
                    @endif
					<a href="{{ route('payments.delete', array($payment->id, $payment->invoice_id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>

</table>