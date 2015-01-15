@section('jscript')
@parent
<script type="text/javascript">
	$().ready(function() {
		$('#btn-check-update').click(function() {
			$.get("{{ route('settings.updateCheck') }}")
			.done(function(response) {
				alert(response.message);
			})
			.fail(function(response) {
				alert("{{ trans('fi.unknown_error') }}");
			});
		});
	});  
</script>
@stop

<div class="row">

	<div class="col-md-8">
		<div class="form-group">
			<label>{{ trans('fi.header_title_text') }}: </label>
			{{ Form::text('setting_headerTitleText', Config::get('fi.headerTitleText'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.version') }}: </label>
			<div class="input-group">
				{{ Form::text('version', Config::get('fi.version'), array('class' => 'form-control', 'disabled' => 'disabled')) }}
				<span class="input-group-btn">
					<button class="btn btn-default" id="btn-check-update" type="button">{{ trans('fi.check_for_update') }}</button>
				</span>
			</div>
		</div>
	</div>

</div>

<div class="row">

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.language') }}: </label>
			{{ Form::select('setting_language', $languages, Config::get('fi.language'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.date_format') }}: </label>
			{{ Form::select('setting_dateFormat', $dateFormats, Config::get('fi.dateFormat'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.timezone') }}: </label>
			{{ Form::select('setting_timezone', $timezones, Config::get('fi.timezone'), array('class' => 'form-control')) }}
		</div>
	</div>

</div>

<div class="row">

	<div class="col-md-6">
		<div class="form-group">
			<label>{{ trans('fi.base_currency') }}: </label>
			{{ Form::select('setting_baseCurrency', $currencies, Config::get('fi.baseCurrency'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-6">
		<div class="form-group">
			<label>{{ trans('fi.exchange_rate_mode') }}: </label>
			{{ Form::select('setting_exchangeRateMode', $exchangeRateModes, Config::get('fi.exchangeRateMode'), array('class' => 'form-control')) }}
		</div>
	</div>

</div>

<div class="form-group">
	<label>{{ trans('fi.logo') }}: </label>
	@if ($invoiceLogoImg)
	<p>{{ $invoiceLogoImg }}</p>
	<a href="{{ route('settings.logo.delete') }}">{{ trans('fi.remove_logo') }}</a>
	@endif
	{{ Form::file('logo') }}
</div>