<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $guarded = [];

	/**
	 * The relationships to always eager-load.
	 *
	 * @var array
	 */
	protected $with = ['author'];

	/**
	 * Boot the model.
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('replyCount', function ($builder) {
			$builder->withCount('replies');
		});

		static::deleting(function ($thread) {
			$thread->replies->each->delete();
		});
	}

	/**
	 * Get a string path for the thread.
	 *
	 * @return string
	 */
	public function path()
	{
		return "/threads/{$this->id}";
	}

	/**
	 * A thread belongs to a creator.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * A thread may have many replies.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function replies()
	{
		return $this->hasMany(Reply::class);
	}

	/**
	 * Add a reply to the thread.
	 *
	 * @param $reply
	 */
	public function addReply($reply)
	{
		$this->replies()->create($reply);
	}

	/**
	 * Apply all relevant thread filters.
	 *
	 * @param  Builder       $query
	 * @param  ThreadFilters $filters
	 * @return Builder
	 */
	public function scopeFilter($query, ThreadFilters $filters)
	{
		return $filters->apply($query);
	}
}
