$(function()
{
	$('#modal-copy-invoice').modal();

	$('#modal-copy-invoice').on('shown.bs.modal', function() {
		$("#client_name").focus();
	});

	$("#copy_created_at").inputmask(datepickerFormat);

	var clients = new Bloodhound({
		datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		remote: clientNameLookupRoute + '?query=%QUERY'
	});

	clients.initialize();

	$('#copy_client_name').typeahead(null, {
		minLength: 3,
		source: clients.ttAdapter()
	});
	
	// Creates the invoice
	$('#btn-copy-invoice-submit').click(function()
	{
		$.post(copyInvoiceRoute, { 
			invoice_id: invoiceId,
			client_name: $('#copy_client_name').val(),
			created_at: $('#copy_created_at').val(),
			invoice_group_id: $('#copy_invoice_group_id').val(),
			user_id: userId
		}).done(function(response) {
			window.location = copyInvoiceReturnUrl + '/' + response.id + '/edit';
		}).fail(function(response) {
			if (response.status == 400) {
				showErrors($.parseJSON(response.responseText).errors, '#modal-status-placeholder');
			} else {
				alert(unknownError);
			}
		});
	});
});