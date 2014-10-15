<div class="row">

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.default_quote_template') }}: </label>
			{{ Form::select('setting_quoteTemplate', $quoteTemplates, Config::get('fi.quoteTemplate'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.default_group') }}: </label>
			{{ Form::select('setting_quoteGroup', $invoiceGroups, Config::get('fi.quoteGroup'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.quotes_expire_after') }}: </label>
			{{ Form::text('setting_quotesExpireAfter', Config::get('fi.quotesExpireAfter'), array('class' => 'form-control')) }}
		</div>
	</div>

</div>

<div class="form-group">
	<label>{{ trans('fi.convert_quote_when_approved') }}: </label>
	{{ Form::select('setting_convertQuoteWhenApproved', $yesNoArray, Config::get('fi.convertQuoteWhenApproved'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.default_terms') }}: </label>
	{{ Form::textarea('setting_quoteTerms', Config::get('fi.quoteTerms'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.default_footer') }}: </label>
	{{ Form::textarea('setting_quoteFooter', Config::get('fi.quoteFooter'), array('class' => 'form-control')) }}
</div>