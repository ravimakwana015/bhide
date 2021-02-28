<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	protected $guarded = [];

	protected $appends = ['image','createDate'];

	public function getImageAttribute()
	{
		$user = AppUsers::where('id', $this->attributes['sender_id'])->first();
		if (isset($user)) {
			if(!empty($user->member_image))
			{
				return url('/public/front/concierges_image/') . '/' . $user->member_image;
			}
			else
			{
				return '';
			}
		}
	}
	public function getCreateDateAttribute()
	{
		return date('Y.m.d H:i:s', strtotime($this->attributes['created_at']));
	}
}
