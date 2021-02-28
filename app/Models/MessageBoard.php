<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageBoard extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $guarded = [];
}
