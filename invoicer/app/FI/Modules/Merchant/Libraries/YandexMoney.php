<?php
namespace FI\Modules\Merchant\Libraries;

use Config;
use Omnipay\Omnipay;

class YandexMoney {

	public static function createGateway()
	{
		$gateway = Omnipay::create('YandexMoney');

		$gateway->setPassword(Config::get('payments.merchants.YandexMoney.password'));
		$gateway->setShopId(Config::get('payments.merchants.YandexMoney.shopid'));
		$gateway->setScid(Config::get('payments.merchants.YandexMoney.scid'));
		$gateway->setCurrencyNum(Config::get('payments.merchants.YandexMoney.currencyNum'));
		
		$gateway->setTestMode(Config::get('payments.testMode'));

		return $gateway;
	}

	public static function setPurchaseParameters($purchaseParameters, $params)
	{
		$purchaseParameters['returnUrl'] = route('merchant.invoice.yandexmoney', array($params['urlKey']));
		$purchaseParameters['cancelUrl'] = route('merchant.invoice.cancel', array($params['urlKey']));
	
		$purchaseParameters['urlKey'] = $params['urlKey'];
		if (isset($params['post']) && is_array($params['post'])) {
			if (isset($params['post']['id'])) {
				$purchaseParameters['orderId'] = $params['post']['id'];
			}
			if (isset($params['post']['action'])) {
				$purchaseParameters['action'] = $params['post']['action'];
			}
			if (isset($params['post']['number'])) {
				$purchaseParameters['orderNumber'] = $params['post']['number'];
			}
			if (isset($params['post']['method'])) {
				$purchaseParameters['method'] = $params['post']['method'];
			}
			if (isset($params['post']['invoiceId'])) {
				$purchaseParameters['invoiceId'] = $params['post']['invoiceId'];
			}
			if (isset($params['post']['client'])) {
				$purchaseParameters['customerNumber'] = $params['post']['client'];
			}
			if (isset($params['post']['md5'])) {
				$purchaseParameters['md5'] = $params['post']['md5'];
			}
			if (isset($params['post']['customerNumber'])) {
				$purchaseParameters['customerNumber'] = $params['post']['customerNumber'];
			}
			if (isset($params['post']['orderSumAmount'])) {
				$purchaseParameters['orderSumAmount'] = $params['post']['orderSumAmount'];
			}
			if (isset($params['post']['orderSumCurrencyPaycash'])) {
				$purchaseParameters['orderSumCurrencyPaycash'] = $params['post']['orderSumCurrencyPaycash'];
			}
			if (isset($params['post']['orderSumBankPaycash'])) {
				$purchaseParameters['orderSumBankPaycash'] = $params['post']['orderSumBankPaycash'];
			}

			if (isset($params['post']['label'])) {
				$purchaseParameters['label'] = $params['post']['label'];
			}
			if (isset($params['post']['notification_type'])) {
				$purchaseParameters['notification_type'] = $params['post']['notification_type'];
			}
			if (isset($params['post']['operation_id'])) {
				$purchaseParameters['operation_id'] = $params['post']['operation_id'];
			}
			
		}
		return $purchaseParameters;

	}

	public static function isRedirect()
	{
		return false;
	}

}