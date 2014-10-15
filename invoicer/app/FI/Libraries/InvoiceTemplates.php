<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries;

use FI\Libraries\Directory;

class InvoiceTemplates {

	/**
	 * Returns an array of invoice templates
	 * @return array
	 */
	public static function lists()
	{
		return Directory::listAssocContents(app_path() . '/FI/Modules/Templates/Views/templates/invoices');
	}

}