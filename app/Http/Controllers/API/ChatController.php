<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Gates;
use App\Models\Messages;
use App\Models\Concierges;
use App\Models\AppUsers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ResponseController as ResponseController;

class ChatController extends ResponseController
{
    public function recSortByKey($key = "", $arr = []) 
    {
        usort($arr, function($a, $b) {
            return $a[$key] - $b[$key];
        });
    }

    public function chatDetails(Request $request)
    {
        $concierges = Concierges::where('id',$request->receiver_id)->first();
        $appConciergeUser = AppUsers::where('email',$concierges->email)->first();
        $concierges_id = $appConciergeUser->id;

        $chatDetails =  Messages::where(function($query) use ($request,$concierges_id)
        {
            $query->where(['sender_id' => $concierges_id , 'receiver_id' => $request->sender_id, 'company_id' => $request->company_id ]);
        })->orWhere(function($query) use ($request,$concierges_id)
        {
            $query->where(['sender_id' => $request->sender_id, 'receiver_id' => $concierges_id, 'company_id' => $request->company_id ]);
        })->paginate(100000000);

        if (!empty($chatDetails)) {
            return response()->json(['data' => $chatDetails], 200);
        } else {
            return response()->json(['error' => 'Message Not Available'], 422);
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'company_id' => 'required',
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'message' => 'required',
        );
        $messages = [
            'title.required' => 'Title field is required'
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();

        $conciergesid = Concierges::where('id',$request->receiver_id)->first();
        $userdetail = AppUsers::where('email',$conciergesid->email)->first();

        Messages::create([
            'company_id' => $request->company_id,
            'sender_id' => $request->sender_id,
            'receiver_id' => $userdetail->id,
            'message' => $request->message,
        ]);

        $success['message'] = 'Message Send Successful';
        return $this->sendResponse($success);

    }

    public function chatList(Request $request)
    {
        $rules = array(
            'company_id' => 'required|numeric',
        );
        $messages = [

        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();

        $sender_id =  Messages::where(function($query) use ($request)
        {
            $query->where(['company_id' => $request->company_id ]);
        })->orWhere(function($query) use ($request)
        {
            $query->where(['company_id' => $request->company_id ]);
        })->pluck('sender_id')->toArray();

        $receiver_id =  Messages::where(function($query) use ($request)
        {
            $query->where(['company_id' => $request->company_id ]);
        })->orWhere(function($query) use ($request)
        {
            $query->where(['company_id' => $request->company_id ]);
        })->pluck('receiver_id')->toArray();

        $mergearry = array_merge($sender_id,$receiver_id);

        $lastarray = array_unique($mergearry);

        $appConciergeUser = AppUsers::where('company_id',$input['company_id'])->whereIn('id',$lastarray)->where('user_type','company')->pluck('email')->toArray();

        $notes = Concierges::where('company_id',$input['company_id'])->whereIn('email',$appConciergeUser)->orderBy('id','desc')->get();
        
        if (!empty($notes)) 
        {
            $conciergeslists = [];
            foreach ($notes as $key => $singleMessage) 
            {
                $messagesValid = Messages::where('sender_id',$singleMessage->getIdofAppUser->id)->orwhere('receiver_id',$singleMessage->getIdofAppUser->id)->orderBy('id','desc')->first();
                $conciergeslists[$messagesValid->id] = $singleMessage;
                $conciergeslists[$messagesValid->id]->lastmessage = $messagesValid->message;
                $conciergeslists[$messagesValid->id]->lastmessageDate =  Carbon::parse($messagesValid->created_at)->format('Y.m.d H:i:s');
                $notes[$key]->messageId = $messagesValid->id;
                $notes[$key]->lastmessage = $messagesValid->message;
                $notes[$key]->lastmessageDate =  Carbon::parse($messagesValid->created_at)->format('Y.m.d H:i:s');
            }
        }

        if(isset($notes))
        {
            //$notes = (array) $notes;  
            // $chatlists = $this->recSortByKey('messageId',$notes);
            
            return response()->json(['data' => $notes], 200);
        }
        else
        {
            $error = 'Concierge Not available';
            return $this->sendError($error, 401);
        }
    }



    public function chatSearch(Request $request)
    {
        $rules = array(
            'company_id' => 'required|numeric',
        );
        $messages = [

        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();


        $notes = Concierges::where('company_id',$input['company_id'])->Where('first_name', 'LIKE', '%'.$input['search'].'%')->orWhere('last_name', 'LIKE', '%'.$input['search'].'%')->get();

        if (!empty($notes)) 
        {
            foreach ($notes as $key => $singleMessage) 
            {
                $messages = Messages::where('sender_id',$singleMessage->id)->orWhere('receiver_id',$singleMessage->id)->orderBy('id','desc')->first();
                if(!empty($messages))
                {
                    $notes[$key]->lastmessage = $messages->message;
                    $notes[$key]->lastmessageDate =  Carbon::parse($messages->created_at)->format('Y.m.d H:i:s');
                }
            }
        }

        if(isset($notes))
        {
            return response()->json(['data' => $notes], 200);
        }
        else
        {
            $error = 'Concierge Not available';
            return $this->sendError($error, 401);
        }
    }
}
