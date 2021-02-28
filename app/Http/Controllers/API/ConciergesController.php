<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Gates;
use App\Models\Concierges;
use App\Http\Controllers\Controller;

class ConciergesController extends Controller
{
    public function conciergeDetails(Request $request)
    {
        $concierge = Concierges::where('concierges.company_id', $request->company_id)
            ->where('concierges.id', $request->company_id)
            ->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
            ->select([
                'concierges.*',
                DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
                'g.id as cid',
                'g.name as gate_name',
            ])
            ->orderBy('id', 'desc')
            ->first();
        if (isset($concierge)) {
            return response()->json(['data' => $concierge], 200);
        } else {
            return response()->json(['error' => 'Concierge Not Found'], 422);
        }
    }
}
