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
	Route::get('clients', array('uses' => 'ClientController@index', 'as' => 'clients.index'));
	Route::get('clients/create', array('uses' => 'ClientController@create', 'as' => 'clients.create'));
	Route::get('clients/{client}/edit', array('uses' => 'ClientController@edit', 'as' => 'clients.edit'));
	Route::get('clients/{client}', array('uses' => 'ClientController@show', 'as' => 'clients.show'));
	Route::get('clients/{client}/delete', array('uses' => 'ClientController@delete', 'as' => 'clients.delete'));
	Route::get('clients/ajax/name_lookup', array('uses' => 'ClientController@ajaxNameLookup', 'as' => 'clients.ajax.nameLookup'));
	
	Route::post('clients/create', array('uses' => 'ClientController@store', 'as' => 'clients.store'));
	Route::post('clients/{client}/edit', array('uses' => 'ClientController@update', 'as' => 'clients.update'));
});