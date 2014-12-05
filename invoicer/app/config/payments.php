<?php

return array(

	// If you do not want to accept online payments, set 'enabled' to false.
	// If you do want to accept online payments, set 'enabled' to true.
	'enabled' => true,

	// The merchant account to use for your transactions. Choose from the
	// list of merchants below.
	'default' => 'YandexMoney',

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

		'YandexMoney' => array(

			'password'  => '132654789',// Пароль магазина в системе Яндекс.Деньги. Выдается оператором системы.
			'method_pc' => 1, // электронная валюта Яндекс.Деньги. 1 - используется, 0 - нет 
			'method_ac' => 1, // банковские карты VISA, MasterCard, Maestro. 1 - используется, 0 - нет 
			'method_gp' => 1, // Только для юридического лица! Наличными в кассах и терминалах партнеров. 1 - используется, 0 - нет 
			'method_mc' => 1, // Только для юридического лица! Оплата со счета мобильного телефона. 1 - используется, 0 - нет 
			'method_wm' => 1, // Только для юридического лица! Электронная валюта WebMoney. 1 - используется, 0 - нет */
			'shopid' => '132',   // Только для юридического лица! Идентификатор вашего магазина в Яндекс.Деньгах (ShopID) 
			'scid' => '57331',    // Только для юридического лица! Идентификатор витрины вашего магазина в Яндекс.Деньгах (scid)
			'currencyNum' => 10643 //10643 - demomoney, 643 - rub, 840 - usd, 978 - euro, 980 - uah

		),

		'YandexMoneyIndividual' => array(

			'account'  => '410011680044609', // Только для физического лица! Идентификатор магазина в системе Яндекс.Деньги. Выдается оператором системы
			'password'  => 'dUtlwyajCX6osFzTuZriXPQJ',// Пароль магазина в системе Яндекс.Деньги. Выдается оператором системы.
			'method_pc' => 1, // электронная валюта Яндекс.Деньги. 1 - используется, 0 - нет 
			'method_ac' => 1, // банковские карты VISA, MasterCard, Maestro. 1 - используется, 0 - нет 
			'currencyNum' => 10643 //10643 - demomoney, 643 - rub, 840 - usd, 978 - euro, 980 - uah

		),

		'Stripe' => array(

			'apiKey'    => '2123123123sdfds', // Your Stripe publishable key
			'secretKey' => 'sadasdsadasd'  // Your Stripe secret key

		)
	)

);
