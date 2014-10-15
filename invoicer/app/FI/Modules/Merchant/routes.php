<?php

Route::filter('merchant_enabled', function()
{
	if (!Config::get('payments.enabled'))
	{
		return Redirect::route('merchant.disabled');
	}
});

Route::get('merchant/disabled', array('uses' => 'MerchantController@disabled', 'as' => 'merchant.disabled'));

Route::group(array('before' => 'merchant_enabled'), function()
{
	Route::get('merchant/invoice/{urlKey}/pay', array('uses' => 'MerchantController@invoicePay', 'as' => 'merchant.invoice.pay'));
	Route::get('merchant/invoice/{urlKey}/return', array('uses' => 'MerchantController@invoiceReturn', 'as' => 'merchant.invoice.return'));
	Route::get('merchant/invoice/{urlKey}/cancel', array('uses' => 'MerchantController@invoiceCancel', 'as' => 'merchant.invoice.cancel'));
	Route::post('merchant/invoice/{urlKey}/modal_cc', array('uses' => 'MerchantController@invoiceModalCc', 'as' => 'merchant.invoice.modalCc'));
	Route::post('merchant/invoice/{urlKey}/validate', array('uses' => 'MerchantController@invoicePay', 'as' => 'merchant.invoice.payCc'));

});