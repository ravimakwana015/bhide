<?php
namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Visitors;
use App\Http\Controllers\Controller;

class VisitorsController extends Controller
{

    public function visitors(Request $request){
        $visitors = Visitors::where('visitors.company_id',$request->company_id)
        ->where('visitors.unit_id',$request->unit_id)
        ->leftJoin('gates as g', 'g.id', '=', 'visitors.gate_id')
        ->leftJoin('units as u', 'visitors.unit_id', '=', 'u.id')
        ->leftJoin('reason_for_visits as rv', 'visitors.reason_id', '=', 'rv.id')
        ->select([
            'visitors.*',
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
            'g.id as cid',
            'g.name as gate_name',
            'rv.reason',
        ])->orderBy('id', 'desc')->paginate(10);
        if (isset($visitors)) {
            return response()->json(['data' => $visitors], 200);
        } else {
            return response()->json(['error' => 'Visitors Not Found'], 422);
        }
    }

}
?>
