<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries;

use FI\Libraries\Directory;

class QuoteTemplates {

	/**
	 * Returns an array of quote templates
	 * @return array
	 */
	public static function lists()
	{
		return Directory::listAssocContents(app_path() . '/FI/Modules/Templates/Views/templates/quotes');
	}

}