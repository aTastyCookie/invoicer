<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries\PDF\Drivers;

use Config;
use FI\Libraries\PDF\PDFInterface;

define('DOMPDF_ENABLE_AUTOLOAD', false);
define('DOMPDF_TEMP_DIR', base_path() . '/app/storage');

require_once base_path() . '/vendor/dompdf/dompdf/dompdf_config.inc.php';

class domPDF implements PDFInterface {

    protected $paperSize;
    protected $paperOrientation;

    private function getPdf($html)
    {
        $paperSize        = $this->paperSize ?: (Config::get('fi.paperSize') ?: 'letter');
        $paperOrientation = $this->paperOrientation ?: (Config::get('fi.paperOrientation') ?: 'portrait');

        \Log::info('Paper Size: ' . $paperSize);
        \Log::info('Paper Orientation: ' . $paperOrientation);

        $pdf = new \DOMPDF();
        $pdf->set_paper($paperSize, $paperOrientation);
        $pdf->load_html($html);
        $pdf->render();

        return $pdf;
    }

    public function save($html, $filename)
    {
        $pdf = $this->getPdf($html);

        file_put_contents($filename, $pdf->output());
    }

    public function download($html, $filename)
    {
        $pdf = $this->getPdf($html);

        $pdf->stream($filename);
    }

    public function setPaperSize($paperSize)
    {
        $this->paperSize = $paperSize;
    }

    public function setPaperOrientation($paperOrientation)
    {
        $this->paperOrientation = $paperOrientation;
    }

}