<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	
	protected $guarded = [];
	protected $appends = ['agentimage'];

    public function getAgentimageAttribute()
    {
        if (isset($this->attributes['agent_image'])) {
            return url('/public/front/agent_image/') . '/' . $this->attributes['agent_image'];
        }
    }
}
