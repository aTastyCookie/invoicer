<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Libraries\PDF;

use Config;
use FI\Libraries\Directory;

class PDFFactory {

    public static function create()
    {
        $class = 'FI\Libraries\PDF\Drivers\\' . Config::get('fi.pdfDriver');

        return new $class;
    }

    public static function getDrivers()
    {
        $driverFiles = Directory::listContents(app_path() . '/FI/Libraries/PDF/Drivers');
        $drivers     = array();

        foreach ($driverFiles as $driverFile)
        {
            $driver = str_replace('.php', '', $driverFile);

            $drivers[$driver] = $driver;
        }

        return $drivers;
    }

}