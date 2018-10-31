<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
	protected $guarded = [];

	protected $with = ['from', 'to'];

	public function from(){
		return $this->belongsTo(User::class, 'user_id_from', 'id');
	}

	public function to(){
		return $this->belongsTo(User::class, 'user_id_to', 'id');
	}
}
