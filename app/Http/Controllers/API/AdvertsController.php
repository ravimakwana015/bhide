<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Adverts;
use App\Http\Controllers\Controller;

class AdvertsController extends Controller
{

    public function adverts(Request $request){
        $services = Adverts::where('status',1)->orderBy('id', 'desc')->paginate(10);
        if (isset($services)) {
            return response()->json(['data' => $services], 200);
        } else {
            return response()->json(['error' => 'Adverts Not Found'], 422);
        }
    }

}
?>
