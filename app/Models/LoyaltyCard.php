<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CompanySettings;

class LoyaltyCard extends Model
{
    protected $dates = [
		'created_at',
		'updated_at',
	];
    protected $guarded = [];
    protected $appends = ['cardImage','owner'];
    public function getCardImageAttribute()
    {
        $companySettings = CompanySettings::where('company_id', $this->attributes['company_id'])->first();
        if (isset($companySettings) && !empty($companySettings->loyalty_card_image)) {
            return url('/storage/app/img/loyaltyCard/') . '/' . $companySettings->loyalty_card_image;
        }
    }
    public function getOwnerAttribute()
    {
        $user = LoyaltyCategorys::where('id', $this->attributes['category_id'])->first();
        if (isset($user)) {
            return $user->lcategory_name;
        }
        else
        {
            return 'no';
        }
    }
}
