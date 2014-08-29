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

class Directory {
	
	/**
	 * Provide a list of directory contents minus the top directory
	 * @param  string $path
	 * @return array
	 */
	public static function listContents($path)
	{
		return array_diff(scandir($path), array('.', '..'));
	}

	/**
	 * Provide an associative array of directory contents ['dir' => 'dir']
	 * @param  string $path
	 * @return array
	 */
	public static function listAssocContents($path)
	{
		$files = self::listContents($path);

		return array_combine($files, $files);
	}

}