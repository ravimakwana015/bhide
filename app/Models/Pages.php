<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Pages extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
}
