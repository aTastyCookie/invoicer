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

abstract class BaseRepository {

	public function all()
	{
		return $this->model->all();
	}

	public function find($id)
	{
		return $this->model->find($id);
	}

	public function findOrFail($id)
	{
		return $this->model->findOrFail($id);
	}

	public function firstOrFail($id)
	{
		return $this->model->firstOrFail($id);
	}

	public function create($input)
	{
		return $this->model->create($input);
	}

	public function firstOrCreate($input)
	{
		return $this->model->firstOrCreate($input);
	}

	public function update($input, $id)
	{
		$model = $this->model->find($id);

		$model->fill($input);

		$model->save();

		return $model;
	}

	public function delete($id)
	{
		$this->model->destroy($id);
	}

	public function count()
	{
		return $this->model->count();
	}

}