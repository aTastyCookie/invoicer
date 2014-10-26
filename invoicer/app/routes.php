<?php

Route::get('resetpw', function()
{
	$user = \FI\Modules\Users\Models\User::where('email', 'your@email.com')->first();

	$user->password = \Hash::make('thenewpassword');

	$user->save();
});