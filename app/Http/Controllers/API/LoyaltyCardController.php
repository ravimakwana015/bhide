<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\LoyaltyCard;
use App\Http\Controllers\Controller;

class LoyaltyCardController extends Controller
{

    public function loyaltyCardStores(Request $request)
    {

        $loyaltyCards = LoyaltyCard::where('company_id', $request->company_id)->orderBy('id','desc')->get();

        $group = array();

        foreach ( $loyaltyCards as $value ) {
            $group[$value->owner]['categoryname'] = $value['owner'];
            $group[$value->owner]['items'][] = $value;
        }
        
        if(isset($group)) {
            asort($group);
            return response()->json(['data' => $group], 200);
        } else {
            return response()->json(['msg' => 'Loyalty Cards Not Found', 'data' => null, 'success' => false], 422);
        }


        // $loyaltyCards = LoyaltyCard::where('company_id', $request->company_id)
        //     ->orderBy('id', 'desc')->paginate(10);
        // if (isset($loyaltyCards)) {
        //     return response()->json(['data' => $loyaltyCards], 200);
        // } else {
        //     return response()->json(['error' => 'Loyalty Cards Not Found'], 422);
        // }
    }
}
