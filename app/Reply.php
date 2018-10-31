<?php

namespace App;

use App\Thread;
use App\Filters\ReplyFilters;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	/**
	 * Don't auto-apply mass assignment protection.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	protected $with = ['author'];

	/**
	 * A reply has an owner.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * A reply belongs to a thread.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function thread()
	{
		return $this->belongsTo(Thread::class);
	}


	public function scopeFilter($query, ReplyFilters $filters)
	{
		return $filters->apply($query);
	}
}
