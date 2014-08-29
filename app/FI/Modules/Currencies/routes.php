<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('before' => 'auth'), function()
{
	Route::get('currencies', array('uses' => 'CurrencyController@index', 'as' => 'currencies.index'));
	Route::get('currencies/create', array('uses' => 'CurrencyController@create', 'as' => 'currencies.create'));
	Route::get('currencies/{taxRate}/edit', array('uses' => 'CurrencyController@edit', 'as' => 'currencies.edit'));
	Route::get('currencies/{taxRate}/delete', array('uses' => 'CurrencyController@delete', 'as' => 'currencies.delete'));

	Route::post('currencies', array('uses' => 'CurrencyController@store', 'as' => 'currencies.store'));
	Route::post('currencies/{taxRate}', array('uses' => 'CurrencyController@update', 'as' => 'currencies.update'));
});