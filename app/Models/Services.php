<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategorys;

class Services extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	protected $guarded = [];
	protected $appends = ['owner'];

	public function getOwnerAttribute()
	{
		$user = ServiceCategorys::where('id', $this->attributes['category_id'])->first();
		if (isset($user)) {
			return $user->category_name;
		}
		else
		{
			return 'no';
		}
	}
}
