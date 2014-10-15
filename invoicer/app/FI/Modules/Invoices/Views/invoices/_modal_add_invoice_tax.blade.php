<script type="text/javascript">
	$(function()
	{
		$('#add-invoice-tax').modal();

		$('#btn-submit-invoice-tax').click(function()
		{
			$.post("{{ route('invoices.ajax.saveInvoiceTax') }}", { 
				invoice_id: {{ $invoice_id }},
				tax_rate_id: $('#tax_rate_id').val(),
				include_item_tax: $('#include_item_tax').val()
			}).done(function(response) {
				window.location = "{{ route('invoices.edit', array($invoice_id)) }}";
			}).fail(function(response) {
				if (response.status == 400) {
					showErrors($.parseJSON(response.responseText).errors, '#modal-status-placeholder');
				} else {
					alert("{{ trans('fi.unknown_error') }}");
				}
			});
		});
	});
</script>

<div class="modal fade" id="add-invoice-tax">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('fi.add_tax') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.tax_rate') }}</label>
                        <div class="col-sm-9">
                            {{ Form::select('tax_rate_id', $taxRates, null, array('id' => 'tax_rate_id', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.tax_rate_placement') }}</label>
                        <div class="col-sm-9">
                            {{ Form::select('include_item_tax', $includeItemTax, null, array('id' => 'include_item_tax', 'class' => 'form-control')) }}
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="btn-submit-invoice-tax" class="btn btn-primary">{{ trans('fi.submit') }}</button>
            </div>
        </div>
    </div>
</div>