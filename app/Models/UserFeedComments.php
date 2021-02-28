<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\AppUsers;
// use App\Models\UserFeedsLikes\UserFeedsLikes;
// use App\Models\UserFeedComments\UserFeedComments;

class UserFeedComments extends Model
{
	protected $fillable =
	[
		"feed_id",
		"user_id",
		"comment",
	];
	protected $dates = 
	[
		'created_at',
		'updated_at',
	];

	protected $appends = ['userimage'];

	public function commentOwner()
	{
		return $this->belongsTo(AppUsers::class,'user_id', 'id');
	}

	public function getUserimageAttribute()
	{
		$user = AppUsers::where('id', $this->attributes['user_id'])->first();
		if (isset($user)) {
			return url('/public/front/member_image/') . '/' . $user->member_image;
		}
	}
}
