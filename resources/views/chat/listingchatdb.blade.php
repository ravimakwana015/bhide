<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompanySettings;
use App\Models\Messages;
use App\Models\Concierges;
use App\Http\Controllers\NotificationController;
use App\Models\AppUsers;
use Carbon\Carbon;
use DB;

class ChatController extends Controller
{
	public function index()
	{
		return view('chat.listingchat');
	}

	public function chatParticular(Request $request,$id)
	{
		$rules = array(
			'company_id' => 'required|numeric',
		);
		$messages = [

		];

		$input=$request->all();

		$sender_id =  Messages::where(function($query) use ($request)
		{
			$query->where(['company_id' => Auth::user()->company->id ]);
		})->orWhere(function($query) use ($request)
		{
			$query->where(['company_id' => Auth::user()->company->id ]);
		})->pluck('sender_id')->toArray();

		$receiver_id =  Messages::where(function($query) use ($request)
		{
			$query->where(['company_id' => Auth::user()->company->id ]);
		})->orWhere(function($query) use ($request)
		{
			$query->where(['company_id' => Auth::user()->company->id ]);
		})->pluck('receiver_id')->toArray();

		$mergearry = array_merge($sender_id,$receiver_id);

		$lastarray = array_unique($mergearry);

		$data['chatLists'] = AppUsers::where('company_id', Auth::user()->company->id)->where('user_type','resident')->whereIn('id',$lastarray)->get();

		$endTime = Carbon::parse(date('H:i'))->addHour(8);

		$data['conciergesOnline'] = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->whereTime('shift_start', '>=', date('H:i'))
		->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
		])
		->orderBy('id', 'desc')
		->get(5)->toArray();

		
		if(count($data['conciergesOnline']) < 5)
		{
			$data['conciergesAll'] = Concierges::where('concierges.company_id', Auth::user()->company->id)
            // ->whereTime('shift_start', '>=', date('H:i'))
            // ->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
			])
			->orderBy('id', 'desc')
			->get(5)->toArray();

			$data['conciergesActive'] = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->whereTime('shift_start', '>=', date('H:i'))
			->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
			])
			->orderBy('id', 'desc')
			->get(5)->toArray();

			$data['conciergesUnique'] = array_merge($data['conciergesAll'],$data['conciergesActive']);
			// $data['concierges'] = array_unique($data['conciergesUnique']);
			$data['concierges'] = array_unique($data['conciergesUnique'], SORT_REGULAR);
		}
		else
		{
			$data['concierges'] = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->whereTime('shift_start', '>=', date('H:i'))
			->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
			])
			->orderBy('id', 'desc')
			->get(5)->toArray();
		}
		

		$data['conciergesCount'] = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->whereTime('shift_start', '>=', date('H:i'))
		->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
		])
		->orderBy('id', 'desc')
		->count();

		return view('chat.listingchat',$data);
	}

	public function chatSlide(Request $request)
	{
		$data['sender'] = $request->Concierge_id;
		
		$concierges = Concierges::where('id',$request->Concierge_id)->first();
		// $appConciergeUser = AppUsers::where('email',$concierges->email)->first();
		$appConciergeUser = AppUsers::where('id',$request->Concierge_id)->first();
		
		$concierges_id = $appConciergeUser->id;
		$name = $appConciergeUser->last_name.' '.$appConciergeUser->first_name;

		if(isset($appConciergeUser))
		{
			$data['chatDetails'] = Messages::where(function($query) use ($request,$concierges_id)
			{
				$query->where(['sender_id' =>$request->appUserid, 'receiver_id' => $concierges_id, 'company_id' => Auth::user()->company->id ]);
			})->orWhere(function($query) use ($request,$concierges_id)
			{
				$query->where(['sender_id' =>$concierges_id, 'receiver_id' => $request->appUserid, 'company_id' => Auth::user()->company->id ]);
			})->get();
		}
		
		$viewData = view('chat.renderchat', $data)->render();
		return json_encode(array('status'=>1,'data'=>$viewData,'concierges'=>$name));
	}

	public function chatParticularslide(Request $request,NotificationController $notification)
	{
		
		$data['sender'] = $request->Concierge_id;
		$concierges = Concierges::where('id',$request->Concierge_id)->first();
		$appConciergeUser = AppUsers::where('email',$concierges->email)->first();
		$concierges_id = $appConciergeUser->id;
		$name = $concierges->first_name.' '.$concierges->last_name;

		if(!empty($request->message))
		{
			Messages::create([
				'company_id' => Auth::user()->company->id,
				'sender_id' => $appConciergeUser->id,
				'receiver_id' => $request->appUserid,
				'message' => $request->message,
			]);

			$deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
			if (count($deviceTokens) > 0) {
				try {
					$title = 'New Messages Available';
					$body = 'New Messages Available in Chat';
					$type = 'chat';
					$res = $notification->senNotification($deviceTokens, $body, $title, $type);
				} catch (\Throwable $th) {
					throw $th;
				}
			}
		}
		else
		{
			
		}

		$data['chatDetails'] =  Messages::where(function($query) use ($request,$concierges_id)
		{
			$query->where(['sender_id' => $request->appUserid, 'receiver_id' => $concierges_id, 'company_id' => Auth::user()->company->id ]);
		})->orWhere(function($query) use ($request,$concierges_id)
		{
			$query->where(['sender_id' =>$concierges_id, 'receiver_id' => $request->appUserid, 'company_id' => Auth::user()->company->id ]);
		})->get();

		$viewData = view('chat.renderchat', $data)->render();
		
		return json_encode(array('status'=>1,'data'=>$viewData,'concierges'=>$name));
	}

	public function feed()
	{
		return view('feed');
	}

	public function chatSearch(Request $request)
	{
		$data['chatDetails'] =  Messages::where(function($query) use ($request)
		{
			$query->where(['sender_id' =>$request->appUserid, 'receiver_id' =>$request->Concierge_id, 'company_id' => Auth::user()->company->id ]);
		})->orWhere(function($query) use ($request)
		{
			$query->where(['sender_id' =>$request->Concierge_id, 'receiver_id' =>$request->appUserid, 'company_id' => Auth::user()->company->id ]);
		})->get();

		$data['sender'] = $request->Concierge_id;
		
		$concierges = Concierges::where('id',$request->Concierge_id)->first();
		
		$name = $concierges->last_name.' '.$concierges->first_name;

		$viewData = view('chat.renderchat', $data)->render();
		return json_encode(array('status'=>1,'data'=>$viewData,'concierges'=>$name));
	}




	public function chatListing(Request $request,$id)
	{
		$rules = array(
			'company_id' => 'required|numeric',
		);
		$messages = [

		];

		$input=$request->all();

		$senderId = Messages::where('company_id', Auth::user()->company->id)->pluck('sender_id')->toArray();
		$receiverId = Messages::where('company_id', Auth::user()->company->id)->pluck('receiver_id')->toArray();

		$mergeAllIds = array_merge($senderId,$receiverId);
		$AllUniqueIds = array_unique($mergeAllIds);

		// $data['chatLists'] = AppUsers::where('company_id', Auth::user()->company->id)->whereIn('id',$AllUniqueIds)->where('user_type','resident')->get();
		
		$conciergesLists = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
		])
		->orderBy('id', 'desc')
		->get();

		$conciergesOnline = [];
		$conciergesOffline = [];

		foreach ($conciergesLists as $key => $conciergesList) 
		{
			$onlineStatus = getOnlineStatus($conciergesList->shift_start,$conciergesList->shift_end);
			if($onlineStatus == 'inactive')
			{
				$conciergesOffline[] = $conciergesList;
			}
			else
			{
				$conciergesOnline[] = $conciergesList;
			}
		}
		
		///// Online Concierges Lists Start /////
		
		$onlineConciergesIds = [];
		foreach ($conciergesOnline as $conkey => $conciergesOn) 
		{
			$onlineConciergesIds[$conkey] = $conciergesOn->email;
		}

		$conciergesAsChatUserIds = AppUsers::select('id')
		->whereIn('email', $onlineConciergesIds)
		->pluck('id')->toArray();

		$messagesarrays = Messages::leftjoin('app_users', 'app_users.id', '=', 'messages.receiver_id')
		->whereIn('sender_id',$conciergesAsChatUserIds)
		->where('app_users.user_type','resident')
		->get();

		
		$finalChatListArray = [];
		foreach ($messagesarrays as $key => $messagesarray) 
		{
			foreach ($conciergesAsChatUserIds as $mkey => $value) 
			{
				if($value == $messagesarray->sender_id)
				{
					$finalChatListArray[$value][] = $messagesarray;
				}
			}
		}
		
		$data['chatLists'] = $finalChatListArray;
		
		//// Online Concierges Lists End /////

		$conciergesOnlineCounts = count($conciergesOnline);
		if(count($conciergesOnline) < 5)
		{
			$count = count($conciergesOnline);
			foreach ($conciergesOffline as $keyof => $conciergesOff) 
			{
				if($count < 5)
				{
					$conciergesOnline[] = $conciergesOff;
				}
				$count++;
			}
			$data['concierges'] = $conciergesOnline;
		}
		else
		{
			$data['concierges'] = $conciergesOnline;
		}
		

		$data['conciergesOnline'] = $conciergesOnline;
		
		$data['conciergesCount'] = count($conciergesOnline);
		$data['conciergesOnlineCount'] = $conciergesOnlineCounts;

		return view('chat.listingchat',$data);
	}
}
