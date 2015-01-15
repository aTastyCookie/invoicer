@extends('layouts.master')

@section('content')

<script type="text/javascript">
	$(function() {
		$('#name').focus(); 
	});
</script>

@if ($editMode == true)
{{ Form::model($itemLookup, array('route' => array('itemLookups.update', $itemLookup->id), 'class' => 'form-horizontal')) }}
@else
{{ Form::open(array('route' => 'itemLookups.store', 'class' => 'form-horizontal')) }}
@endif

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.item_lookup_form') }}
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
							<label class="">{{ trans('fi.name') }}: </label>
							{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label class="">{{ trans('fi.description') }}: </label>
							{{ Form::textarea('description', null, array('id' => 'description', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label class="">{{ trans('fi.price') }}: </label>
							{{ Form::text('price', (($editMode) ? $itemLookup->formatted_numeric_price: null), array('id' => 'price', 'class' => 'form-control')) }}
						</div>

					</div>

				</div>

			</div>

		</div>

	</section>

</aside>

{{ Form::close() }}
@stop