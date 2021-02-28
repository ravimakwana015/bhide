<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\MessageBoard;
use App\Http\Controllers\Controller;

class MessageBoardController extends Controller
{

    public function messages(Request $request){
        $messageBoard = MessageBoard::where('company_id',$request->company_id)->orderBy('id', 'desc')->paginate(10);
        if (isset($messageBoard)) {
            return response()->json(['data' => $messageBoard], 200);
        } else {
            return response()->json(['error' => 'Messages Are Not Found'], 422);
        }
    }

}
?>
