<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Libraries;

use Config;
use Omnipay\Omnipay;

class YandexKassa {

	public static function createGateway()
	{
		$gateway = Omnipay::create('YandexMoneyKassa');

		$gateway->setUsername(Config::get('payments.merchants.YandexKassa.username'));
		$gateway->setPassword(Config::get('payments.merchants.YandexKassa.password'));
		$gateway->setSignature(Config::get('payments.merchants.YandexKassa.signature'));
		$gateway->setTestMode(Config::get('payments.testMode'));

		return $gateway;
	}

	public static function setPurchaseParameters($purchaseParameters, $params)
	{
		$purchaseParameters['returnUrl'] = route('merchant.invoice.return', array($params['urlKey']));
		$purchaseParameters['cancelUrl'] = route('merchant.invoice.cancel', array($params['urlKey']));

		return $purchaseParameters;

	}

	public static function isRedirect()
	{
		return true;
	}

}