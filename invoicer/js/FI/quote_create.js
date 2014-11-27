$(function() {

    $('#create-quote').modal();

    $('#create-quote').on('shown.bs.modal', function() {
        $("#create_client_name").focus();
    });

    $("#create_created_at").inputmask(datepickerFormat);

    var clients = new Bloodhound({
        datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.num); },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: clientNameLookupRoute + '?query=%QUERY'
    });

    clients.initialize();

    $('#create_client_name').typeahead(null, {
        minLength: 3,
        source: clients.ttAdapter()
    });

    $('#quote-create-confirm').click(function() {

        $.post(storeQuoteRoute, { 
            client_name: $('#create_client_name').val(), 
            created_at: $('#create_created_at').val(),
            invoice_group_id: $('#create_invoice_group_id').val()
        }).done(function(response) {
            window.location = createQuoteReturnUrl + '/' + response.id + '/edit';
        }).fail(function(response) {
            if (response.status == 400) {
                showErrors($.parseJSON(response.responseText).errors, '#modal-status-placeholder');
            } else {
                alert(unknownError);
            }
        });
    });

});