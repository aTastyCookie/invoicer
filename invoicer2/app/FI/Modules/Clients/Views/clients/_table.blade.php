<table class="table table-hover">

	<thead>
		<tr>
			<th>{{ trans('fi.client_name') }}</th>
			<th>{{ trans('fi.email_address') }}</th>
			<th>{{ trans('fi.phone_number') }}</th>
			<th style="text-align: right;">{{ trans('fi.balance') }}</th>
			<th>{{ trans('fi.active') }}</th>
			<th>{{ trans('fi.options') }}</th>
		</tr>
	</thead>

	<tbody>
		@foreach ($clients as $client)
		<tr>
			<td>{{ link_to_route('clients.show', $client->name, array($client->id)) }}</td>
			<td>{{{ $client->email }}}</td>
			<td>{{{ (($client->phone ? $client->phone : ($client->mobile ? $client->mobile : ''))) }}}</td>
			<td style="text-align: right;">{{ $client->formatted_balance }}</td>
			<td>{{ ($client->active) ? trans('fi.yes') : trans('fi.no') }}</td>
			<td>
				<div class="btn-group">
					<a href="{{ route('clients.show', array($client->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.view') }}"><i class="fa fa-search"></i></a> 
					<a href="{{ route('clients.edit', array($client->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
					<a href="{{ route('clients.delete', array($client->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_client_warning') }}');"><i class="fa fa-trash-o"></i></a> 
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>

</table>