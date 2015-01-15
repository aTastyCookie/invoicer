$(function() {

    $('#create-invoice').modal();

    $('#create-invoice').on('shown.bs.modal', function() {
        $("#create_client_name").focus();
    });

    $("#create_created_at").inputmask(datepickerFormat);

    $('input[name=recurring]:radio').change(function () {
        if ($(this).val() == 1) {
            $('#div-recurring-options').show();
        }
        else {
            $('#div-recurring-options').hide();
        }
    });

    $('#invoice-create-confirm').click(function() {

        $.post(storeInvoiceRoute, { 
            client_name: $('#create_client_name').val(), 
            created_at: $('#create_created_at').val(),
            invoice_group_id: $('#create_invoice_group_id').val(),
            recurring: $("input:radio[name=recurring]:checked").val(),
            recurring_frequency: $('#recurring_frequency').val(),
            recurring_period: $('#recurring_period').val()
        }).done(function(response) {
            window.location = createInvoiceReturnUrl + '/' + response.id + '/edit';
        }).fail(function(response) {
            if (response.status == 400) {
                showErrors($.parseJSON(response.responseText).errors, '#modal-status-placeholder');
            } else {
                alert(unknownError);
            }
        });
    });

});