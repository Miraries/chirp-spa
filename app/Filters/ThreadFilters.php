<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
	/**
	 * Registered filters to operate upon.
	 *
	 * @var array
	 */
	protected $filters = ['by', 'popular'];

	protected function by($id)
	{
		return $this->builder->where('user_id', $id);
	}

	protected function popular()
	{
		$this->builder->getQuery()->orders = [];

		return $this->builder->orderBy('replies_count', 'desc');
	}
}