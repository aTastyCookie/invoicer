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

use Config;

define('DOMPDF_ENABLE_AUTOLOAD', false);

require_once base_path() . '/vendor/dompdf/dompdf/dompdf_config.inc.php';

class PDF {

	protected $pdf;

	public function __construct($html)
	{
		$paperSize        = Config::get('fi.paperSize') ?: 'letter';
		$paperOrientation = Config::get('fi.paperOrientation') ?: 'portrait';

		$this->pdf = new \DOMPDF();
		$this->pdf->set_paper($paperSize, $paperOrientation);
		$this->pdf->load_html($html);
		$this->pdf->render();
	}

	public function save($filename)
	{
		file_put_contents($filename, $this->pdf->output());
	}

	public function download($filename)
	{
		$this->pdf->stream($filename);
	}

	public function base64()
	{
		return base64_encode($this->pdf->output());
	}

}