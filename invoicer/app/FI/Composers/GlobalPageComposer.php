<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Composers;

use Config;

class GlobalPageComposer {

    public function compose($view)
    {
        $view->with('mailConfigured', Config::get('mailConfigured'));
    }

}