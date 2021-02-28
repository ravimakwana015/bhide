<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmailDatas extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
}