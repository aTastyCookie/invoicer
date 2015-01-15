<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('before' => 'auth', 'namespace' => 'FI\Modules\PaymentMethods\Controllers'), function()
{
	Route::get('payment_methods', array('uses' => 'PaymentMethodController@index', 'as' => 'paymentMethods.index'));
	Route::get('payment_methods/create', array('uses' => 'PaymentMethodController@create', 'as' => 'paymentMethods.create'));
	Route::get('payment_methods/{paymentMethod}/edit', array('uses' => 'PaymentMethodController@edit', 'as' => 'paymentMethods.edit'));
	Route::get('payment_methods/{paymentMethod}/delete', array('uses' => 'PaymentMethodController@delete', 'as' => 'paymentMethods.delete'));

	Route::post('payment_methods', array('uses' => 'PaymentMethodController@store', 'as' => 'paymentMethods.store'));
	Route::post('payment_methods/{paymentMethod}', array('uses' => 'PaymentMethodController@update', 'as' => 'paymentMethods.update'));
});