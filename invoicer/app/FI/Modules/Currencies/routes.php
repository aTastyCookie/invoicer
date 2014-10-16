<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('before' => 'auth'), function()
{
	Route::get('currencies', array('uses' => 'CurrencyController@index', 'as' => 'currencies.index'));
	Route::get('currencies/create', array('uses' => 'CurrencyController@create', 'as' => 'currencies.create'));
	Route::get('currencies/{currency}/edit', array('uses' => 'CurrencyController@edit', 'as' => 'currencies.edit'));
	Route::get('currencies/{currency}/delete', array('uses' => 'CurrencyController@delete', 'as' => 'currencies.delete'));

	Route::post('currencies', array('uses' => 'CurrencyController@store', 'as' => 'currencies.store'));
    Route::post('currencies/get-exchange-rate', array('uses' => 'CurrencyController@getExchangeRate', 'as' => 'currencies.getExchangeRate'));
	Route::post('currencies/{currency}', array('uses' => 'CurrencyController@update', 'as' => 'currencies.update'));

});