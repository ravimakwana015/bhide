<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Appnotifications extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
    protected $appends = ['createDate'];

    public function getCreateDateAttribute()
	{
		return date('Y.m.d H:i:s', strtotime($this->attributes['created_at']));
	}
}
