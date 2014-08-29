<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Import\Importers;

class ImportFactory {

	public static function create($importType)
	{
		switch ($importType)
		{
			case 'clients':
				return new ClientImporter();
			case 'quotes':
				return new QuoteImporter();
			case 'invoices':
				return new InvoiceImporter();
			case 'payments':
				return new PaymentImporter();
			case 'invoiceItems':
				return new InvoiceItemImporter();
			case 'quoteItems':
				return new QuoteItemImporter();
			case 'itemLookups':
				return new ItemLookupImporter();
		}
	}
}