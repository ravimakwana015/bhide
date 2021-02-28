<?php

namespace App;

use Laravel\Cashier\Subscription;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Company;
use App\Models\AppUserDetails;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function owner()
    {
        return $this -> belongsTo(Subscription::class, 'id', 'user_id');
    }
    public function company()
    {
        return $this -> belongsTo(Company::class, 'id', 'user_id');
    }
    public function appUserDetails()
    {
        return $this -> belongsTo(AppUserDetails::class, 'id', 'user_id');
    }
}
