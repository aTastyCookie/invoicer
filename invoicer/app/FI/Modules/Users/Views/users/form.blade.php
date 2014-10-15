@extends('layouts.master')

@section('content')

<script type="text/javascript">
	$(function() {
		$('#name').focus(); 
	});
</script>

@if ($editMode == true)
{{ Form::model($user, array('route' => array('users.update', $user->id), 'class' => 'form-horizontal')) }}
@else
{{ Form::open(array('route' => 'users.store', 'class' => 'form-horizontal')) }}
@endif

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.user_form') }}
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
							<label>{{ trans('fi.name') }}: </label>
							{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.email') }}: </label>
							{{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control')) }}
						</div>

						@if (!$editMode)
						<div class="form-group">
							<label>{{ trans('fi.password') }}: </label>
							{{ Form::password('password', array('id' => 'password', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.password_confirmation') }}: </label>
							{{ Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control')) }}
						</div>
						@endif

						<div class="form-group">
							<label>{{ trans('fi.company') }}: </label>
							{{ Form::text('company', null, array('id' => 'company', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.address') }}: </label>
							{{ Form::textarea('address', null, array('id' => 'address', 'class' => 'form-control', 'rows' => 4)) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.phone') }}: </label>
							{{ Form::text('phone', null, array('id' => 'phone', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.fax') }}: </label>
							{{ Form::text('fax', null, array('id' => 'fax', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.mobile') }}: </label>
							{{ Form::text('mobile', null, array('id' => 'mobile', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.web') }}: </label>
							{{ Form::text('web', null, array('id' => 'web', 'class' => 'form-control')) }}
						</div>

					</div>

				</div>

				@if ($customFields->count())
				<div class="box box-primary">

					<div class="box-header">
						<h3 class="box-title">{{ trans('fi.custom_fields') }}</h3>
					</div>

					<div class="box-body">

						@include('custom_fields._custom_fields')

					</div>

				</div>
				@endif

			</div>

		</div>

	</section>

</aside>

{{ Form::close() }}
@stop