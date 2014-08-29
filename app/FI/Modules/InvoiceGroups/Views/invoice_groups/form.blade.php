@extends('layouts.master')

@section('content')

<script type="text/javascript">
	$(function() {
		$('#name').focus(); 
	});
</script>

@if ($editMode == true)
{{ Form::model($invoiceGroup, array('route' => array('invoiceGroups.update', $invoiceGroup->id), 'class' => 'form-horizontal')) }}
@else
{{ Form::open(array('route' => 'invoiceGroups.store', 'class' => 'form-horizontal')) }}
@endif

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.group_form') }}
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
							<label >{{ trans('fi.name') }}: </label>
							{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label >{{ trans('fi.next_id') }}: </label>
							{{ Form::text('next_id', isset($invoiceGroup->next_id) ? $invoiceGroup->next_id : 0, array('id' => 'next_id', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label >{{ trans('fi.left_pad') }}: </label>
							{{ Form::text('left_pad', isset($invoiceGroup->left_pad) ? $invoiceGroup->left_pad : 0, array('id' => 'left_pad', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label >{{ trans('fi.prefix') }}: </label>
							{{ Form::text('prefix', null, array('id' => 'prefix', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label >{{ trans('fi.year_prefix') }}: </label>
							{{ Form::select('prefix_year', array('0' => trans('fi.no'), '1' => trans('fi.yes')), null, array('id' => 'prefix_year', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label >{{ trans('fi.month_prefix') }}: </label>
							{{ Form::select('prefix_month', array('0' => trans('fi.no'), '1' => trans('fi.yes')), null, array('id' => 'prefix_month', 'class' => 'form-control')) }}
						</div>

				</div>

			</div>

		</div>

	</div>

</section>

</aside>

{{ Form::close() }}
@stop