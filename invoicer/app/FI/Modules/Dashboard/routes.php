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
	Route::get('/', 'DashboardController@index');
	Route::get('dashboard', array('uses' => 'DashboardController@index', 'as' => 'dashboard.index'));
});