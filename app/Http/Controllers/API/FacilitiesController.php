<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Facilities;
use App\Http\Controllers\Controller;

class FacilitiesController extends Controller
{

    public function facilities(Request $request){
        $facilities = Facilities::where('company_id',$request->company_id)->orderBy('id', 'desc')->paginate(10);
        if (isset($facilities)) {
            return response()->json(['data' => $facilities], 200);
        } else {
            return response()->json(['error' => 'facilities Not Found'], 422);
        }
    }

}
?>
