@extends('layouts.master')

@section('jscript')

<script type="text/javascript">
	$(function() {
		$('#btn-submit').click(function() {
			$.post("{{ route('reports.revenueByClient.ajax.run') }}", { 
				year: $('#year').val()
			}).done(function(response) {
				clearErrors();
				$('#report-results').html(response);
			}).fail(function(response) {
				showErrors($.parseJSON(response.responseText).errors, '#form-validation-placeholder');
			});
		});
	});
</script>
@stop

@section('content')

<aside class="right-side">

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.revenue_by_client') }}
		</h1>
		@if ($years)
		<div class="pull-right">
			<button class="btn btn-primary" id="btn-submit">{{ trans('fi.run_report') }}</button>
		</div>
		@endif
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

							<div class="col-lg-12">
								@if ($years)
								<label>{{ trans('fi.year') }}</label>
								<div class="input-group">
									{{ Form::select('year', $years, date('Y'), array('id' => 'year', 'class' => 'form-control')) }}
								</div>
								@else
								<p>This report will be available once you have some payments entered in the system.</p>
								@endif
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