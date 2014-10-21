<?php

return array(

	// If you do not want to accept online payments, set 'enabled' to false.
	// If you do want to accept online payments, set 'enabled' to true.
	'enabled' => true,

	// The merchant account to use for your transactions. Choose from the
	// list of merchants below.
	'default' => 'YandexKassa',

	// When testing your payment gateway integration, set this to true.
	// When using your payment gateway in production, set this to false.
	'testMode' => true,

	// This is the list of supported merchants and the required settings for
	// each merchant.
	'merchants' => array(

		'PayPalExpress' => array(

			'username'  => '', // Your PayPal API username
			'password'  => '', // Your PayPal API password
			'signature' => ''  // Your PayPal API signature

		),

		'Stripe' => array(

			'apiKey'    => '', // Your Stripe publishable key
			'secretKey' => ''  // Your Stripe secret key

		),

		'YandexKassa' => array(

			'shopid' 	=> '', // Your YandexMoney shopid
			'scid'		=> '', // Your Yandexmoney scid
			'shoppw' 	=> ''  // Your YandexMoney shoppw

		)
	)

);