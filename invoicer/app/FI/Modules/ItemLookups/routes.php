<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('before' => 'auth', 'namespace' => 'FI\Modules\ItemLookups\Controllers'), function()
{
	Route::get('item_lookups', array('uses' => 'ItemLookupController@index', 'as' => 'itemLookups.index'));
	Route::get('item_lookups/create', array('uses' => 'ItemLookupController@create', 'as' => 'itemLookups.create'));
	Route::get('item_lookups/{itemLookup}/edit', array('uses' => 'ItemLookupController@edit', 'as' => 'itemLookups.edit'));
	Route::get('item_lookups/{itemLookup}/delete', array('uses' => 'ItemLookupController@delete', 'as' => 'itemLookups.delete'));
	Route::get('item_lookups/ajax/item_lookup', array('uses' => 'ItemLookupController@ajaxItemLookup', 'as' => 'itemLookups.ajax.itemLookup'));

	Route::post('item_lookups', array('uses' => 'ItemLookupController@store', 'as' => 'itemLookups.store'));
	Route::post('item_lookups/{itemLookup}', array('uses' => 'ItemLookupController@update', 'as' => 'itemLookups.update'));
	Route::post('item_lookups/ajax/process', array('uses' => 'ItemLookupController@process', 'as' => 'itemLookups.ajax.process'));
});