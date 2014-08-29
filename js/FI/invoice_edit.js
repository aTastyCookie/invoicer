$(function() {

	$("#created_at").inputmask(datepickerFormat);
	$("#due_at").inputmask(datepickerFormat);

	$('#btn-add-tax').click(function() {
		$('#modal-placeholder').load(addTaxModalRoute, { invoice_id: invoiceId });
	});

	$('#btn-copy-invoice').click(function() {
		$('#modal-placeholder').load(copyInvoiceModalRoute, { invoice_id: invoiceId });
	});

	$('#btn-invoice-to-invoice').click(function() {
		$('#modal-placeholder').load(invoiceToInvoiceRoute, {
			invoice_id: invoiceId,
			client_id: clientId
		});
	});

	$('#btn-save-invoice').click(function() {
		var items = [];
		var item_order = 1;
		var custom_fields = {};
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

		$.post(invoiceUpdateRoute, {
			number: $('#number').val(),
			created_at: $('#created_at').val(),
			due_at: $('#due_at').val(),
			invoice_status_id: $('#invoice_status_id').val(),
			items: JSON.stringify(items),
			terms: $('#terms').val(),
			footer: $('#footer').val(),
			currency_code: $('#currency_code').val(),
			exchange_rate: $('#exchange_rate').val(),
			custom: JSON.stringify(custom_fields)
		}).done(function(response) {
			window.location = invoiceEditRoute;
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