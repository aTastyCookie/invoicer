$(function() {

	$("#created_at").inputmask(datepickerFormat);
	$("#expires_at").inputmask(datepickerFormat);
    $('textarea').autosize();

	$('#btn-add-tax').click(function() {
		$('#modal-placeholder').load(addTaxModalRoute, { quote_id: quoteId });
	});

	$('#btn-copy-quote').click(function() {
		$('#modal-placeholder').load(copyQuoteModalRoute, { quote_id: quoteId });
	});

	$('#btn-quote-to-invoice').click(function() {
		$('#modal-placeholder').load(quoteToInvoiceRoute, {
			quote_id: quoteId,
			client_id: clientId
		});
	});

    $('#btn-update-exchange-rate').click(function() {
        updateExchangeRate();
    });

    $('#currency_code').change(function() {
        updateExchangeRate();
    });

    function updateExchangeRate() {
        $.post(getExchangeRateRoute, { currency_code: $('#currency_code').val() }, function(data) {
            $('#exchange_rate').val(data);
        });
    }

	$('.btn-save-quote').click(function() {
		var items = [];
		var item_order = 1;
		var custom_fields = {};
        var apply_exchange_rate = $(this).data('apply-exchange-rate');

        $('table tr.item').each(function() {
			var row = {};
			$(this).find('input,select,textarea').each(function() {
				if ($(this).is(':checkbox')) {
					if ($(this).is(':checked')) {
						row[$(this).attr('name')] = 1;
					}
					else {
						row[$(this).attr('name')] = 0;
					}
				} 
				else {
					row[$(this).attr('name')] = $(this).val();
				}
			});
			row['item_order'] = item_order;
			item_order++;
			items.push(row);
		});

		$('.custom-form-field').each(function() {
			custom_fields[$(this).data('field-name')] = $(this).val();
		});

		$.post(quoteUpdateRoute, {
			number: $('#number').val(),
			created_at: $('#created_at').val(),
			expires_at: $('#expires_at').val(),
			quote_status_id: $('#quote_status_id').val(),
			items: JSON.stringify(items),
			terms: $('#terms').val(),
			footer: $('#footer').val(),
			currency_code: $('#currency_code').val(),
			exchange_rate: $('#exchange_rate').val(),
			custom: JSON.stringify(custom_fields),
            apply_exchange_rate: apply_exchange_rate,
            template: $('#template').val()
        }).done(function(response) {
			window.location = quoteEditRoute;
		}).fail(function(response) {
			if (response.status == 400) {
				showErrors($.parseJSON(response.responseText).errors, '#form-status-placeholder');
			} else {
				alert(unknownError);
			}
		});
	});

	var fixHelper = function(e, tr) {
		var $originals = tr.children();
		var $helper = tr.clone();
		$helper.children().each(function(index) {
			$(this).width($originals.eq(index).width())
		});
		return $helper;
	};

	$("#item-table tbody").sortable({
		helper: fixHelper
	});

});