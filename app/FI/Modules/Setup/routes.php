<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('setup', array('uses' => 'SetupController@index', 'as' => 'setup.index'));
Route::post('setup', array('uses' => 'SetupController@postIndex', 'as' => 'setup.postIndex'));

Route::get('setup/prerequisites', array('uses' => 'SetupController@prerequisites', 'as' => 'setup.prerequisites'));

Route::get('setup/migration', array('uses' => 'SetupController@migration', 'as' => 'setup.migration'));
Route::post('setup/migration', array('uses' => 'SetupController@postMigration', 'as' => 'setup.postMigration'));

Route::get('setup/account', array('uses' => 'SetupController@account', 'as' => 'setup.account'));
Route::post('setup/account', array('uses' => 'SetupController@postAccount', 'as' => 'setup.postAccount'));

Route::get('setup/complete', array('uses' => 'SetupController@complete', 'as' => 'setup.complete'));