<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AppUsers;
use App\Models\Notes;
use Auth;
use App\Http\Controllers\Controller;
use URL;
use DB;
use App\Http\Controllers\API\ResponseController as ResponseController;

class NoteController extends ResponseController
{

    public function index(Request $request)
    {
        $notes = Notes::where('user_id',$request->user_id)->orderBy('id', 'desc')->paginate(10);

        if (isset($notes)) {
            return response()->json(['data' => $notes], 200);
        } else {
            return response()->json(['error' => 'Notes Not Found'], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'title' => 'required',
        );
        $messages = [
            'title.required' => 'Title field is required'
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();
        
        Notes::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
        ]);

        $success['message'] = 'Note Added successful';
        return $this->sendResponse($success);
        
    }

    public function updateNote(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'note_id' => 'required',
            'title' => 'required',
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['error' => $validator->errors()], 422);
        }
        else 
        {
            $notes = Notes::where('id', $request->note_id)->first();
            if (isset($notes)) {

                $notes->update([
                    'user_id' => $request->user_id,
                    'title' => $request->title,
                    'sub_title' => $request->sub_title,
                    'description' => $request->description,
                ]);
                
                return response()->json(['success' => 'Note Update SuccessFully'], 200);
            } else {
                return response()->json(['error' => 'Note Not Found'], 422);
            }
        }
    }

    public function deleteNote(Request $request)
    {
        $rules = array(
            'note_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        );
        $messages = [
            'note_id.required' => 'Note Id field is required'
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();
        $notes=Notes::where('id',$input['note_id'])->where('user_id',$input['user_id'])->first();
        if(isset($notes)){
            $notes->delete();
            $success['message'] = 'Note Deleted successful';
            return $this->sendResponse($success);
        }else{
            $error = 'Note Not available';
            return $this->sendError($error, 401);
        }
    }
}