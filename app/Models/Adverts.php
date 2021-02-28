<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adverts extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	protected $fillable = [
		'redirect_url','instagram_url','image', 'status','title'
	];

	public $table = 'adverts';
	protected $appends = ['imageUri'];
	public function getImageUriAttribute()
	{
		if (isset($this->attributes['image'])) {

			return url('/storage/app/img/ads') . '/' . $this->attributes['image'];
		}
	}
}
