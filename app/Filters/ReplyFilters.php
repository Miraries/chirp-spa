<?php

namespace App\Filters;

use App\User;

class ReplyFilters extends Filters
{
	/**
	 * Registered filters to operate upon.
	 *
	 * @var array
	 */
	protected $filters = ['by'];

	protected function by($id)
	{
		return $this->builder->where('user_id', $id);
	}
}