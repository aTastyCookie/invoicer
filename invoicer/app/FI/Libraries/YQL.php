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

class YQL {

	protected $baseUrl = 'http://query.yahooapis.com/v1/public/yql';

	public function getQueryResults($query)
	{
		$session = curl_init($this->baseUrl . '?q=' . $query . '&format=json');
		curl_setopt($session, CURLOPT_RETURNTRANSFER,true);    
		return curl_exec($session);
	}

}