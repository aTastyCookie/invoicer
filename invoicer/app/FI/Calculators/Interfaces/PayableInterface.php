<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Calculators\Interfaces;

interface PayableInterface {
	
	/**
	 * Set the total paid amount
	 * @param float $totalPaid
	 */
	public function setTotalPaid($totalPaid);

	/**
	 * Calculate additional properties
	 * @return void
	 */
	public function calculatePayments();

}