<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = [];

    public $table = 'real_estates';
    protected $appends = ['agentimageurl','lease_length'];

    public function getLeaseLengthAttribute()
    {
        if ($this->attributes['lease_length'] == '3') 
        {
            return '3 Months';
        }
        elseif($this->attributes['lease_length'] == '6')
        {
            return '6 Months';
        }
        elseif($this->attributes['lease_length'] == '9')
        {
            return '9 Months';
        }
        elseif($this->attributes['lease_length'] == '12')
        {
            return '1 Year';
        }
        elseif($this->attributes['lease_length'] == '24')
        {
            return '2 Year';
        }
        elseif($this->attributes['lease_length'] == '36')
        {
            return '3 Year';
        }
    }

    public function getAgentimageurlAttribute()
    {
        $user = Agents::where('id', $this->attributes['agent_id'])->first();
        if (isset($user)) {
            return $user->agent_image;
        }
    }

}
