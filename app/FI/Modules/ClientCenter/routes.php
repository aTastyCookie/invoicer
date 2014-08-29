<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('prefix' => 'client_center'), function()
{
	Route::get('invoice/{invoiceKey}', array('uses' => 'ClientCenterInvoiceController@show', 'as' => 'clientCenter.invoice.show'));
	Route::get('invoice/{invoiceKey}/pdf', array('uses' => 'ClientCenterInvoiceController@pdf', 'as' => 'clientCenter.invoice.pdf'));
	Route::get('invoice/{invoiceKey}/html', array('uses' => 'ClientCenterInvoiceController@html', 'as' => 'clientCenter.invoice.html'));
	Route::get('quote/{quoteKey}', array('uses' => 'ClientCenterQuoteController@show', 'as' => 'clientCenter.quote.show'));
	Route::get('quote/{quoteKey}/pdf', array('uses' => 'ClientCenterQuoteController@pdf', 'as' => 'clientCenter.quote.pdf'));
	Route::get('quote/{quoteKey}/html', array('uses' => 'ClientCenterQuoteController@html', 'as' => 'clientCenter.quote.html'));
	Route::get('quote/{quoteKey}/approve', array('uses' => 'ClientCenterQuoteController@approve', 'as' => 'clientCenter.quote.approve'));
	Route::get('quote/{quoteKey}/reject', array('uses' => 'ClientCenterQuoteController@reject', 'as' => 'clientCenter.quote.reject'));
});