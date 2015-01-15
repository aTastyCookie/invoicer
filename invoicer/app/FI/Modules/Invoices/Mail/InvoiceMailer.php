<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Invoices\Mail;

use Event;
use FI\Libraries\PDF\PDFFactory;
use Mail;
use Response;

class InvoiceMailer {

	protected $errors;

	public function send($invoice, $to, $subject, $body, $cc = null, $includeAttachment = false)
	{
		$pdfPath = '';

		// Should the document be attached?
		if ($includeAttachment == true)
		{
			// Define the path
			$pdfPath = app_path() . '/storage/' . trans('fi.invoice') . '_' . $invoice->number . '.pdf';

			// Save the file
			$pdf = PDFFactory::create();

			$pdf->save($invoice->html, $pdfPath);
		}

		try
		{
			Mail::send('templates.emails.template', array('body' => $body), function($message) use ($invoice, $to, $subject, $cc, $pdfPath)
			{
				$message->from($invoice->user->email, $invoice->user->name)
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

				if ($pdfPath)
				{
					$message->attach($pdfPath);
				}
			});

			Event::fire('invoice.emailed', array($invoice));

			if ($pdfPath and file_exists($pdfPath))
			{
				unlink($pdfPath);
			}

			return true;
		}
		catch (\Exception $e)
		{
			if ($pdfPath and file_exists($pdfPath))
			{
				unlink($pdfPath);
			}

			$this->errors = $e->getMessage();
			return false;
		}
	}

	public function errors()
	{
		return $this->errors;
	}

}