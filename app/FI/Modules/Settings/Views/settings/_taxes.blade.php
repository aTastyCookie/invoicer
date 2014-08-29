<div class="form-group">
	<label>{{ trans('fi.default_invoice_tax_rate') }}: </label>
	{{ Form::select('setting_invoiceTaxRate', $taxRates, Config::get('fi.invoiceTaxRate'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.default_invoice_tax_rate_placement') }}: </label>
	{{ Form::select('setting_includeItemTax', $includeItemTax, Config::get('fi.includeItemTax'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.default_item_tax_rate') }}: </label>
	{{ Form::select('setting_itemTaxRate', $taxRates, Config::get('fi.itemTaxRate'), array('class' => 'form-control')) }}
</div>