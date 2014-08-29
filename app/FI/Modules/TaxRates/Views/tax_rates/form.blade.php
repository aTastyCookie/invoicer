@extends('layouts.master')

@section('content')

<script type="text/javascript">
	$(function() {
		$('#name').focus(); 
	});
</script>

@if ($editMode == true)
{{ Form::model($taxRate, array('route' => array('taxRates.update', $taxRate->id), 'class' => 'form-horizontal')) }}
@else
{{ Form::open(array('route' => 'taxRates.store', 'class' => 'form-horizontal')) }}
@endif

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.tax_rate_form') }}
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

						<div class="form-group">
							<label>{{ trans('fi.tax_rate_name') }}: </label>
							{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.tax_rate_percent') }}: </label>
							{{ Form::text('percent', (($editMode) ? $taxRate->formatted_numeric_percent : null), array('id' => 'percent', 'class' => 'form-control')) }}
						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

</aside>

{{ Form::close() }}
@stop