@extends('layouts.master')

@section('jscript')

@include('layouts._datemask')

<script type="text/javascript">
	$(function() {
		$('#btn-submit').click(function() {
				$.post("{{ route('reports.paymentsCollected.ajax.run') }}", { 
					from_date: $('#from_date').val(), 
					to_date: $('#to_date').val()
				}).done(function(response) {
					clearErrors();
					$('#report-results').html(response);
				}).fail(function(response) {
					showErrors($.parseJSON(response.responseText).errors, '#form-validation-placeholder');
				});
			});

		$("#from_date").inputmask("{{ Config::get('fi.datepickerFormat') }}");
		$("#to_date").inputmask("{{ Config::get('fi.datepickerFormat') }}");
	});
</script>
@stop

@section('content')

<aside class="right-side">

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.payments_collected') }}
		</h1>
		<div class="pull-right">
			<button class="btn btn-primary" id="btn-submit">{{ trans('fi.run_report') }}</button>
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="content">

		<div class="row">

			<div class="col-md-12">

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">{{ trans('fi.options') }}</h3>
					</div>
					<div class="box-body">

						<div class="row">

							<div class="col-xs-2">
								<label>{{ trans('fi.from_date') }}</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									{{ Form::text('from_date', null, array('id' => 'from_date', 'class' => 'form-control')) }}
								</div>
							</div>
							<div class="col-xs-2">
								<label>{{ trans('fi.to_date') }}</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									{{ Form::text('to_date', null, array('id' => 'to_date', 'class' => 'form-control')) }}
								</div>
							</div>

						</div>

					</div>

				</div>
			</div>

		</div>

		<div id="report-results">

		</div>

	</section>

</aside>

@stop