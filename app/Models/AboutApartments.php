<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Units;
use App\Models\Settings;

class AboutApartments extends Model
{
	protected $dates = [
		'created_at',
		'updated_at',
	];
	
	protected $guarded = [];
	protected $appends = ['image','owner','parking','concierge','fitness'];
    public function getImageAttribute()
    {
        $user = Company::where('id', $this->attributes['company_id'])->first();
		if (isset($user)) {
			return $user->company_name;
		}
    }
    public function getOwnerAttribute()
	{
		$user = Units::where('id', $this->attributes['unit_id'])->first();
		if (isset($user)) {
			return $user->block_number . '-' . $user->flat_number;
		}
	}
	public function getParkingAttribute()
	{
		$user = Settings::first();
		if (isset($user)) {
			return $user->parking_Information;
		}
	}
	public function getConciergeAttribute()
	{
		$user = Settings::first();
		if (isset($user)) {
			return $user->concierge;
		}
	}
	public function getFitnessAttribute()
	{
		$user = Settings::first();
		if (isset($user)) {
			return $user->fitness_centre;
		}
	}
}
