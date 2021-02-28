<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
	// public function services(Request $request){
	// 	$services = Services::where('company_id',$request->company_id)->orderBy('id', 'desc')->paginate(10);
	// 	if (isset($services)) {
	// 		return response()->json(['data' => $services], 200);
	// 	} else {
	// 		return response()->json(['error' => 'Services Not Found'], 422);
	// 	}
	// }

	public function services(Request $request){

		$services = Services::where('company_id', $request->company_id)->orderBy('id', 'desc')->get();

		$group = array();

		foreach ( $services as $value ) {
			$group[$value->owner]['categoryname'] = $value['owner'];
			$group[$value->owner]['items'][] = $value;
		}


		// array_multisort($group[$value->owner], SORT_DESC,$group);
		
		if(isset($group)) {
			asort($group);
			return response()->json(['data' => $group], 200);
		} else {
			return response()->json(['msg' => 'Services Not Found', 'data' => null, 'success' => false], 422);
		}
	}
}
?>
