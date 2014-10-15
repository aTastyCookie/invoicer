<table class="table table-hover">

	<thead>
		<tr>
			<th>{{ trans('fi.status') }}</th>
			<th>{{ trans('fi.quote') }}</th>
			<th>{{ trans('fi.created') }}</th>
			<th>{{ trans('fi.expires') }}</th>
			<th>{{ trans('fi.client_name') }}</th>
			<th style="text-align: right; padding-right: 25px;">{{ trans('fi.amount') }}</th>
			<th>{{ trans('fi.options') }}</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($quotes as $quote)
		<tr>
			<td>
                <span class="label label-{{ $statuses[$quote->quote_status_id] }}">{{ trans('fi.' . $statuses[$quote->quote_status_id]) }}</span>
				@if ($quote->viewed) 
				<span class="label label-success">{{ trans('fi.viewed') }}</span>
				@else
				<span class="label label-default">{{ trans('fi.not_viewed') }}</span>
				@endif
			</td>
			<td><a href="{{ route('quotes.edit', array($quote->id)) }}" title="{{ trans('fi.edit') }}">{{ $quote->number }}</a></td>
			<td>{{ $quote->formatted_created_at }}</td>
			<td>{{ $quote->formatted_expires_at }}</td>
			<td><a href="{{ route('clients.show', array($quote->client->id)) }}" title="{{ trans('fi.view_client') }}">{{ $quote->client->name }}</a></td>
			<td style="text-align: right; padding-right: 25px;">{{ $quote->amount->formatted_total }}</td>
			<td>
				<div class="btn-group">
					<a href="{{ route('quotes.edit', array($quote->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
					<a href="{{ route('quotes.pdf', array($quote->id)) }}" target="_blank" id="btn-pdf-quote" class="btn btn-sm btn-default" title="{{ trans('fi.pdf') }}"><i class="fa fa-print"></i></a>
					@if ($mailConfigured)
					<a href="javascript:void(0)" class="btn btn-sm btn-default email-quote" data-quote-id="{{ $quote->id }}" data-redirect-to="{{ Request::fullUrl() }}" title="{{ trans('fi.email') }}"><i class="fa fa-envelope"></i></a> 
					@endif
                    <a href="{{ route('clientCenter.quote.show', array($quote->url_key)) }}" target="_blank" id="btn-public-quote" class="btn btn-sm btn-default" title="{{ trans('fi.public') }}"><i class="fa fa-globe"></i></a>
					<a href="{{ route('quotes.delete', array($quote->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
				</div>

			</td>
		</tr>
		@endforeach
	</tbody>

</table>