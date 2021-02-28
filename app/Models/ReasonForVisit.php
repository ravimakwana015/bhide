<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonForVisit extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
}
