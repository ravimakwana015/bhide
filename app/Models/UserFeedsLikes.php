<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
// use App\Models\UserFeedsLikes\UserFeedsLikes;
// use App\Models\UserFeedComments\UserFeedComments;

class UserFeedsLikes extends Model
{
	protected $fillable =
	[
		"feed_id",
		"user_id",
	];
	protected $dates = 
	[
		'created_at',
		'updated_at',
	];
	
}
