<div class="row">

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.default_invoice_template') }}: </label>
			{{ Form::select('setting_invoiceTemplate', $invoiceTemplates, Config::get('fi.invoiceTemplate'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.default_group') }}: </label>
			{{ Form::select('setting_invoiceGroup', $invoiceGroups, Config::get('fi.invoiceGroup'), array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>{{ trans('fi.invoices_due_after') }}: </label>
			{{ Form::text('setting_invoicesDueAfter', Config::get('fi.invoicesDueAfter'), array('class' => 'form-control')) }}
		</div>
	</div>

</div>

<div class="form-group">
	<label>{{ trans('fi.default_terms') }}: </label>
	{{ Form::textarea('setting_invoiceTerms', Config::get('fi.invoiceTerms'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.default_footer') }}: </label>
	{{ Form::textarea('setting_invoiceFooter', Config::get('fi.invoiceFooter'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.automatic_email_on_recur') }}: </label>
	{{ Form::select('setting_automaticEmailOnRecur', array('0' => trans('fi.no'), '1' => trans('fi.yes')), Config::get('fi.automaticEmailOnRecur'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.automatic_email_payment_receipts') }}: </label>
	{{ Form::select('setting_automaticEmailPaymentReceipts', array('0' => trans('fi.no'), '1' => trans('fi.yes')), Config::get('fi.automaticEmailPaymentReceipts'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
	<label>{{ trans('fi.online_payment_method') }}: </label>
	{{ Form::select('setting_onlinePaymentMethod', $paymentMethods, Config::get('fi.onlinePaymentMethod'), array('class' => 'form-control')) }}
</div>