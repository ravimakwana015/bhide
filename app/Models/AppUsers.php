<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AppUsers extends Authenticatable
{
    use Notifiable,HasApiTokens;

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = [];
    protected $appends = ['unit','image'];

    public function getImageAttribute()
    {
        if (isset($this->attributes['member_image'])) {
            return url('/public/front/member_image/') . '/' . $this->attributes['member_image'];
        }
    }

    public function userCompany(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
    public function userUnit(){
        return $this->belongsTo(Units::class,'unit_id','id');
    }
    public function getUnitAttribute()
    {
        return Units::where('id', $this->attributes['unit_id'])->get();
    }
    public function latestMessage() 
    {
        return $this->hasOne(Messages::class, 'receiver_id')->latest();
    }
}
