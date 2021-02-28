<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $fillable = [
        'company_id',
        'block_number',
        'flat_number',
    ];
    protected $dates = [
		'created_at',
		'updated_at',
	];
}
