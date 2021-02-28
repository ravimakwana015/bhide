<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Concierges extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = [];
    protected $appends = ['image'];
    public function getImageAttribute()
    {
        if (isset($this->attributes['concierge_image'])) {
            return url('/public/front/concierges_image/') . '/' . $this->attributes['concierge_image'];
        }
    }
    // public function getLivestatusAttribute()
    // {
    //     if (isset($this->attributes['shift_start'])) 
    //     {
    //         return getOnlineStatus($this->attributes['shift_start'],$this->attributes['shift_end']);
    //     }
    // }

    public function getIdofAppUser()
    {
        return $this->belongsTo(AppUsers::class,'email','email');
    }
}
