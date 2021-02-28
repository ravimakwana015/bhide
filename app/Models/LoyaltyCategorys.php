<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LoyaltyCategorys;

class LoyaltyCategorys extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	
	protected $guarded = [];
	// protected $appends = ['owner'];

	// public function getOwnerAttribute()
	// {
	// 	$user = LoyaltyCategorys::where('id', $this->attributes['category_id'])->first();
	// 	if (isset($user)) {
	// 		return $user->lcategory_name;
	// 	}
	// 	else
	// 	{
	// 		return 'no';
	// 	}
	// }
	
}
