<?php

/**
 * This file is part of Deskmine.
 *
 * (c) Deskmine
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\CustomFields\Repositories;

use FI\Modules\CustomFields\Models\UserCustom;

class UserCustomRepository {

	/**
	 * Save the record
	 * @param  array $input
	 * @param  int $userId
	 * @return UserCustom
	 */
	public function save($input, $userId)
	{
		$record = (UserCustom::find($userId)) ?: new UserCustom;

		$record->user_id = $userId;
		
		$record->fill($input);

		$record->save();

		return $record;
	}

	/**
	 * Delete a record
	 * @param  int $id
	 * @return void
	 */
	public function delete($id)
	{
		UserCustom::destroy($id);
	}

}