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

class Stripe {

	public static function createGateway()
	{
		$gateway = Omnipay::create('Stripe');

		$gateway->setApiKey(Config::get('payments.merchants.Stripe.secretKey'));
		$gateway->setTestMode(Config::get('payments.testMode'));

		return $gateway;
	}

	public static function setPurchaseParameters($purchaseParameters, $params)
	{
		$purchaseParameters['token'] = $params['post']['stripeToken'];

		return $purchaseParameters;
	}

	public static function isRedirect()
	{
		return false;
	}

}