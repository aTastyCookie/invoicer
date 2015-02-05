@extends('layouts.empty')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1>{{ trans('fi.license_agreement') }}</h1>
	</section>

	<section class="content">

		{{ Form::open() }}

		<div class="row">

			<div class="col-md-12">

				<div class="box box-primary">
					
					<div class="box-body">

						<div class="form-group">
							{{ Form::textarea('license', $license, array('id' => 'license', 'class' => 'form-control', 'readonly' => 'readonly')) }}
						</div>

						<div class="form-group">
							{{ Form::checkbox('accept', 1) }} {{ trans('fi.license_agreement_accept') }}
						</div>

						{{ Form::submit(trans('fi.i_accept'), array('class' => 'btn btn-primary')) }}

					</div>

				</div>

			</div>

		</div>

		{{ Form::close() }}

	</section>

</aside>
@stop