/**
 * Renders error messages into placeholder, styles the input fields. If errors is null, just hides the errors.
 * 
 * @param errors object in following format (Validator->getMessageBag()->toArray() returns this):
 *  ` "inputId": ["Error message."], "anotherInputId": ["Another error message."] ` or null
 * @param placeholder jQuery element where to put error messages
 */
 function showErrors(errors, placeholder) {

    $('.input-group.has-error').removeClass('has-error');
    $(placeholder).html('');
    if (errors == null && placeholder) {
        return;
    }

    $.each(errors, function(id, message) {
        if (id) $('#' + id).parents('.input-group').addClass('has-error');
        if (placeholder) $(placeholder).append('<div class="alert alert-danger">' + message[0] + '</div>');
    });

}

function clearErrors() {
    $('.input-group.has-error').removeClass('has-error');
}

function iCheck() {
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });    
}

$(function() {

    $('ul.sidebar-menu li.treeview ul.treeview-menu li').each(function() {
        var href = $(this).find('a').attr('href');

        if (href == window.location.protocol + '//' + window.location.host + window.location.pathname) {
            $(this).addClass('active');
            $(this).closest('li.treeview').addClass('active');
        }
    });

    $('.create-quote').click(function() {
        $('#modal-placeholder').load(createQuoteModalRoute);
    });

    $('.create-invoice').click(function() {
        $('#modal-placeholder').load(createInvoiceModalRoute);
    });

    $('.email-quote').click(function() {
        $('#modal-placeholder').load(emailQuoteModalRoute, {
            quote_id: $(this).data('quote-id'),
            redirectTo: $(this).data('redirect-to')
        });
    });

    $('.email-invoice').click(function() {
        $('#modal-placeholder').load(emailInvoiceModalRoute, {
            invoice_id: $(this).data('invoice-id'),
            redirectTo: $(this).data('redirect-to')
        });
    });

    $('.enter-payment').click(function() {
        $('#modal-placeholder').load(enterPaymentRoute, {
            invoice_id: $(this).data('invoice-id'),
            invoice_balance: $(this).data('invoice-balance'),
            redirectTo: $(this).data('redirect-to'),
        });
    });

});