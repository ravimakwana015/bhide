<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppUsers;
use App\Models\Agents;

class Feeds extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	protected $guarded = [];
	protected $appends = ['owner','createDate', 'updateDate', 'userimage'];

	public function getOwnerAttribute()
	{
		$user = AppUsers::where('id', $this->attributes['user_id'])->first();
		if (isset($user)) {
			return $user->first_name . ' ' . $user->last_name;
		}
	}
	public function getUserimageAttribute()
	{
		$user = AppUsers::where('id', $this->attributes['user_id'])->first();
		if (isset($user)) {
			return url('/public/front/member_image/') . '/' . $user->member_image;
		}
	}

	public function getCreateDateAttribute()
	{
		return date('Y.m.d H:i:s', strtotime($this->attributes['created_at']));
	}
	public function getUpdateDateAttribute()
	{
		return date('Y.m.d H:i:s', strtotime($this->attributes['updated_at']));
	}
	// public function getImageAttributes()
 //    {
 //        if (isset($this->attributes['user_id'])) {
 //            return url('/public/front/member_image/') . '/' . $this->attributes['user_id'];
 //        }
 //    }
}
