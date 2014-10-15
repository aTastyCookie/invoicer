<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Statuses;

class QuoteStatuses extends AbstractStatuses {

    protected static $statuses = array(
        '0' => 'all',
        '1' => 'draft',
        '2' => 'sent',
        '3' => 'approved',
        '4' => 'rejected',
        '5' => 'canceled'
    );
	
}