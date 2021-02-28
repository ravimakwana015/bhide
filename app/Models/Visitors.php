<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitors extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
    protected $appends = ['checkOut'];
    public  function unitName()
    {
        return $this->belongsTo(Units::class,'unit_id','id');
    }
    public  function getCheckOutAttribute()
    {
        return \Carbon\Carbon::createFromTimeStamp(strtotime($this->attributes['check_in_date']))->diffForHumans();
    }
}
