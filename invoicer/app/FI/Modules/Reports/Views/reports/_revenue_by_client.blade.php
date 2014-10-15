<div class="row">
	<div class="col-md-12">

		<div class="box box-solid">

			<div class="box-body">

				<table class="table table-hover">
					<thead>
						<tr>
							<th>{{ trans('fi.client') }}</th>
							@foreach ($months as $month)
							<th>{{ $month }}</th>
							@endforeach
							<th>{{ trans('fi.total') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($results as $client=>$amounts)
						<tr>
							<td>{{ $client }}</td>
							@foreach (array_keys($months) as $monthKey)
							<td>{{ $amounts['months'][$monthKey] }}</td>
							@endforeach
							<td>{{ $amounts['total'] }}</td>
							@endforeach
						</tr>
					</tbody>
				</table>

			</div>

		</div>

	</div>

</div>