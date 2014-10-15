@extends('layouts.master')

@section('content')

{{ Form::open(array('route' => array('import.map.submit', $importType), 'class' => 'form-horizontal')) }}

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.map_fields_to_import') }}
		</h1>
		<div class="pull-right">
			{{ Form::submit(trans('fi.submit'), array('class' => 'btn btn-primary')) }}
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-md-12">

				<div class="box box-primary">
					
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">

							<tbody>
								@foreach ($importFields as $key => $field)
								<tr>
									<td style="width: 20%;">{{ $field }}</td>
									<td>{{ Form::select($key, $fileFields, null, array('class' => 'form-control')) }}</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>

				</div>

			</div>

		</div>

	</section>

</aside>

{{ Form::close() }}
@stop