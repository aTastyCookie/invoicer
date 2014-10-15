<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(array('before' => 'auth'), function()
{
	Route::get('settings', array('uses' => 'SettingController@index', 'as' => 'settings.index'));
	Route::post('settings', array('uses' => 'SettingController@update', 'as' => 'settings.update'));
	Route::get('settings/update_check', array('uses' => 'SettingController@UpdateCheck', 'as' => 'settings.updateCheck'));
	Route::get('settings/logo/delete', array('uses' => 'SettingController@logoDelete', 'as' => 'settings.logo.delete'));
});