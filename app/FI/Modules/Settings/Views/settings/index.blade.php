@extends('layouts.master')

@section('jscript')
@parent
<script type="text/javascript">
	$().ready(function() {
		$('#btn-submit').click(function() {
			$('#form-settings').submit();
		});
	});  
</script>
@stop

@section('content')

<aside class="right-side">

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.system_settings') }}
		</h1>
		<div class="pull-right">
			<button class="btn btn-primary" id="btn-submit">{{ trans('fi.save') }}</button>
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="content">

	@include('layouts._alerts')

		{{ Form::open(array('route' => 'settings.update', 'files' => true, 'id' => 'form-settings')) }}

		<div class="row">
			<div class="col-md-12">
				
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-general">{{ trans('fi.general') }}</a></li>
						<li><a data-toggle="tab" href="#tab-invoices">{{ trans('fi.invoices') }}</a></li>
						<li><a data-toggle="tab" href="#tab-quotes">{{ trans('fi.quotes') }}</a></li>
						<li><a data-toggle="tab" href="#tab-taxes">{{ trans('fi.taxes') }}</a></li>
						<li><a data-toggle="tab" href="#tab-email">{{ trans('fi.email') }}</a></li>
					</ul>
					<div class="tab-content">
						<div id="tab-general" class="tab-pane active">
							@include('settings._general')
						</div>
						<div id="tab-invoices" class="tab-pane">
							@include('settings._invoices')
						</div>
						<div id="tab-quotes" class="tab-pane">
							@include('settings._quotes')
						</div>
						<div id="tab-taxes" class="tab-pane">
							@include('settings._taxes')
						</div>
						<div id="tab-email" class="tab-pane">
							@include('settings._email')
						</div>
					</div>
				</div>

			</div>

		</div>

		{{ Form::close() }}

	</section>

</aside>

@stop