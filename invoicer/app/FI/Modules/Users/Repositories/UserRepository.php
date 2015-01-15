<?php

/**
 * This file is part of HubPay.
 *
 * (c) HubPay
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FI\Modules\Users\Repositories;

use Config;
use FI\Libraries\BaseRepository;
use FI\Modules\Users\Models\User;

class UserRepository extends BaseRepository {

	public function __construct(User $model)
	{
		$this->model = $model;
	}

	/**
	 * Get a paged list of records
	 * @return User
	 */
	public function getPaged()
	{
		return $this->model->paginate(Config::get('fi.defaultNumPerPage'));
	}

	/**
	 * Get a single record
	 * @param  int $id
	 * @return User
	 */
	public function find($id)
	{
		return $this->model->with('custom')->find($id);
	}

	public function findIdByEmail($email)
	{
		return $this->model->where('email', $email)->first()->id;
	}
	
	/**
	 * Create a record
	 * @param  array $input
	 * @return User
	 */
	public function create($input)
	{
		$user = new User;

		$user->fill($input);

		$user->password = $input['password'];

		$user->save();

		return $user;
	}

	/**
	 * Update a user password
	 * @param  string $password
	 * @param  int $id
	 * @return User
	 */
	public function updatePassword($password, $id)
	{
		$user = $this->model->find($id);

		$user->password = $password;

		$user->save();

		return $user;
	}
	
}