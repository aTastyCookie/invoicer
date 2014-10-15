@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.import_data') }}
		</h1>

		<div class="clearfix"></div>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-xs-12">

				<div class="box box-primary">

					{{ Form::open(array('route' => 'import.upload', 'files' => true)) }}

					<div class="box-body">

						<div class="form-group">
							<label>{{ trans('fi.what_to_import') }}</label>
							{{ Form::select('import_type', $importTypes, null, array('class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.select_file_to_import') }}</label>
							{{ Form::file('import_file') }}
						</div>

					</div>

					<div class="box-footer">
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>

					{{ Form::close() }}

				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop