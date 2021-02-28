<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Company extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];

    public function companyUser(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
