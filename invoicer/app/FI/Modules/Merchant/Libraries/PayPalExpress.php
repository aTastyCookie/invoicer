<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Merchant\Libraries;

use Config;
use Omnipay\Omnipay;

class PayPalExpress {

	public static function createGateway()
	{
		$gateway = Omnipay::create('PayPal_Express');

		$gateway->setUsername(Config::get('payments.merchants.PayPalExpress.username'));
		$gateway->setPassword(Config::get('payments.merchants.PayPalExpress.password'));
		$gateway->setSignature(Config::get('payments.merchants.PayPalExpress.signature'));
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