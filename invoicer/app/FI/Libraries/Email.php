<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries;

class Email {
	
	/**
	 * Provide a list of send methods
	 * @return array
	 */
	static function listSendMethods()
	{
		return array(
			''         => '',
			'smtp'     => trans('fi.email_send_method_smtp'),
			'mail'     => trans('fi.email_send_method_phpmail'),
			'sendmail' => trans('fi.email_send_method_sendmail')
		);
	}

	/**
	 * Provide a list of encryption methods
	 * @return array
	 */
	static function listEncryptions()
	{
		return array(
			'0'   => trans('fi.none'), 
			'ssl' => 'SSL', 
			'tls' => 'TLS'
		);
	}

}