$(function() {

	$('#modal-mail-payment').modal({backdrop: 'static'});
    
	$('#btn-submit-mail-payment').click(function() {

		$('#btn-submit-mail-payment').attr('disabled', 'disabled');

		$('#modal-status-placeholder').html('<div class="alert alert-info">' + sending + '</div>');

		$.post(mailPaymentRoute, {
			payment_id: paymentId,
			to: $('#to').val(),
			cc: $('#cc').val(),
			subject: $('#subject').val(),
			body: $('#body').val(),
			attach_pdf: $('#attach_pdf').prop('checked')
		}).done(function(response) {
			$('#modal-status-placeholder').html('<div class="alert alert-success">' + sent + '</div>');
			setTimeout('window.location=redirectTo', 1000);
		}).fail(function(response) {
			if (response.status == 400) {
				showErrors($.parseJSON(response.responseText).errors, '#modal-status-placeholder');
			} else {
				alert(unknownError);
			}
			$('#btn-mail-payment-confirm').removeAttr('disabled');
		});
	});
});