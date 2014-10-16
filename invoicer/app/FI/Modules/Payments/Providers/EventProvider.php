<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Payments\Providers;

use App;
use Config;
use Event;
use FI\Libraries\Parser;
use Mail;
use Illuminate\Support\ServiceProvider;

class EventProvider extends ServiceProvider {

	/**
	 * Register the service provider
	 * @return void
	 */
	public function register() {}

	/**
	 * Bootstrap the application events
	 * @return void
	 */
	public function boot()
	{
		Event::listen('payment.created', function($payment, $checkEmailOption = true, $body = null)
		{
			// Do not send the payment receipt unless required conditions are met
			if (($checkEmailOption == true and !Config::get('fi.automaticEmailPaymentReceipts')) or !$payment->invoice->client->email)
			{
				return;
			}

			$data = array('body' => ($body) ?: Parser::parse($payment, Config::get('fi.paymentReceiptBody')));

			Mail::send('templates.emails.template', $data, function($message) use($payment)
			{
				$message->from($payment->invoice->user->email, $payment->invoice->user->name);
				$message->to($payment->invoice->client->email, $payment->invoice->client->name);
				$message->subject(trans('fi.payment_receipt'));
			});
		});

	}
}