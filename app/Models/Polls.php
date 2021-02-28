<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polls extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
    protected $appends = ['options','optionsVotes'];
    public function getOptionsAttribute()
    {
        return PollsOptions::where('poll_id', $this->attributes['id'])->get()->toArray();
    }
    public function getOptionsVotesAttribute()
    {
        return PollsVotes::where('poll_id', $this->attributes['id'])->get()->toArray();
    }
}
