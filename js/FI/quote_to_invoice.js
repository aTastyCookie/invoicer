$(function()
{
	// Display the create quote modal
	$('#modal-quote-to-invoice').modal('show');

	$("#to_invoice_created_at").inputmask(datepickerFormat);
	
	// Creates the invoice
	$('#btn-quote-to-invoice-submit').click(function()
	{
		$.post(quoteToInvoiceRoute, { 
			quote_id: quoteId,
			client_id: clientId,
			created_at: $('#to_invoice_created_at').val(),
			invoice_group_id: $('#to_invoice_invoice_group_id').val(),
			user_id: userId
		}).done(function(response) {
			window.location = response.redirectTo;
		}).fail(function(response) {
			if (response.status == 400) {
				showErrors($.parseJSON(response.responseText).errors, '#modal-status-placeholder');
			} else {
				alert(unknownError);
			}
		});
	});
});