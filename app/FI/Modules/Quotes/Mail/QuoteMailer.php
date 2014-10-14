<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Quotes\Mail;

use Event;
use Mail;
use Response;

class QuoteMailer {

	protected $errors;

	public function send($quote, $to, $subject, $body, $cc = null, $attachment = null)
	{
		try
		{
			Mail::send('templates.emails.template', array('body' => $body), function($message) use ($quote, $to, $subject, $cc, $attachment)
			{
				$message->from($quote->user->email, $quote->user->name)
				->subject($subject);

                foreach (explode(',', $to) as $recipient)
                {
                    $message->to(trim($recipient));
                }

                if ($cc)
                {
                    foreach (explode(',', $cc) as $recipient)
                    {
                        $message->cc($recipient);
                    }
                }

				if ($attachment)
				{
					$message->attach($attachment);
				}
			});

			Event::fire('quote.emailed', array($quote));

			return true;
		}
        catch (\Exception $e)
		{
			$this->errors = $e->getMessage();
			return false;
		}
	}

	public function errors()
	{
		return $this->errors;
	}

}