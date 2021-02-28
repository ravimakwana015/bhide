<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Parcels;
use App\Http\Controllers\Controller;

class ParcelsController extends Controller
{

    public function parcels(Request $request)
    {
        $parcels = Parcels::where('parcels.company_id', $request->company_id)
        ->where('parcels.unit_id', $request->unit_id)
        ->leftjoin('units as u', 'parcels.unit_id', '=', 'u.id')
        ->select([
            'parcels.*',
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
        ])
        ->where('parcels.status',$request->status)
        ->orderBy('id', 'desc')
        ->paginate(10);
        if (isset($parcels)) {
            return response()->json(['data' => $parcels,'error' => $request->all()], 200);
        } else {
            return response()->json(['error' => 'parcels Not Found'], 422);
        }
    }
}
