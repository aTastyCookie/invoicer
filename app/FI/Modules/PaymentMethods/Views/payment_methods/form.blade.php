@extends('layouts.master')

@section('content')

<script type="text/javascript">
	$(function() {
		$('#name').focus(); 
	});
</script>

@if ($editMode == true)
{{ Form::model($paymentMethod, array('route' => array('paymentMethods.update', $paymentMethod->id), 'class' => 'form-horizontal')) }}
@else
{{ Form::open(array('route' => 'paymentMethods.store', 'class' => 'form-horizontal')) }}
@endif

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.payment_method_form') }}
		</h1>
		<div class="pull-right">
			{{ Form::submit(trans('fi.save'), array('class' => 'btn btn-primary')) }}
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-md-12">

				<div class="box box-primary">
					
					<div class="box-body">

						<div class="control-group">
							<label>{{ trans('fi.payment_method') }}: </label>
								{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control')) }}
						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

</aside>

{{ Form::close() }}
@stop