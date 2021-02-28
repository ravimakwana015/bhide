<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollsVotes extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	protected $guarded = [];

	public function UserDetails() {
		return $this->hasOne('App\Models\AppUsers', 'id', 'user_id');
	}
}
