<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppUsers;

class UnitIssueRequest extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];

    public function userApp(){
        return $this->belongsTo(AppUsers::class,'user_id','id');
    }
}
