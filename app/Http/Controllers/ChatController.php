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

	public function chatSlide(Request $request)
	{
		$currentTime = Carbon::now();
        $now = $currentTime->toDateTimeString();
		$data['sender'] = $request->Concierge_id;
		
		$concierges = Concierges::where('id',$request->Concierge_id)->first();
		// $appConciergeUser = AppUsers::where('email',$concierges->email)->first();
		$appConciergeUser = AppUsers::where('id',$request->Concierge_id)->first();
		
		$concierges_id = $appConciergeUser->id;
		$name = $appConciergeUser->first_name.' '.$appConciergeUser->last_name;

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

		Messages::where(function($query) use ($request,$concierges_id)
		{
			$query->where(['sender_id' =>$request->appUserid, 'receiver_id' => $concierges_id, 'company_id' => Auth::user()->company->id ]);
		})->orWhere(function($query) use ($request,$concierges_id)
		{
			// $query->where(['sender_id' =>$concierges_id, 'receiver_id' => $request->appUserid, 'company_id' => Auth::user()->company->id ]);
		})->update(['read_at' => $now ]);

		$notificationCount = Messages::where(function($query) use ($request,$concierges_id)
        {
            $query->where('read_at',NULL)->where(['sender_id' =>$request->appUserid, 'receiver_id' => $concierges_id, 'company_id' => Auth::user()->company->id]);
        })->orWhere(function($query) use ($request,$concierges_id)
        {
            // $query->where('read_at',NULL)->where(['sender_id' =>$concierges_id, 'receiver_id' => $request->appUserid, 'company_id' => Auth::user()->company->id ]);
        })->count();
        
		return json_encode(array('status'=>1,'data'=>$viewData,'concierges'=>$name,'countnot'=>$notificationCount));
	}

	public function chatParticularslide(Request $request,NotificationController $notification)
	{

		$data['sender'] = $request->Concierge_id;
		$concierges = Concierges::where('id',$request->Concierge_id)->first();
		$appConciergeUser = AppUsers::where('id',$request->Concierge_id)->first();
		$concierges_id = $appConciergeUser->id;
		$name = $appConciergeUser->first_name.' '.$appConciergeUser->last_name;

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
		$input = $request->all();
		$search = $input['search'];
		$companyId = $input['company_id'];

		$searchAppUserids = AppUsers::where('first_name', 'LIKE', "%{$search}%") ->orWhere('last_name', 'LIKE', "%{$search}%")->where('company_id',$companyId)->where('user_type','resident')->pluck('id')->toArray();

		if(!empty($searchAppUserids))
		{
			$conciergesOnline = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
			])
			->where('livestatus', 'active')
			->orderBy('id', 'desc')
			->get();

			$conciergesOffline = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
			])
			->where('livestatus', 'inactive')
			->orderBy('id', 'desc')
			->get();

			$onlineConciergesIds = [];
			foreach ($conciergesOnline as $conkey => $conciergesOn) 
			{
				$onlineConciergesIds[$conkey] = $conciergesOn->email;
			}

			$conciergesAsChatUserIds = AppUsers::select('id')
			->whereIn('email', $onlineConciergesIds)
			->pluck('id')->toArray();

			$finalChatListArray = [];
			foreach ($conciergesAsChatUserIds as $key => $conciergesAsChatUserId) 
			{
				$searchmessagesarray = AppUsers::whereIn('id',$searchAppUserids)
				->where('app_users.user_type','resident')
				->where('app_users.company_id',Auth::user()->company->id)
				->get();

				if(empty($searchmessagesarray))
				{
					$finalChatListArray[$conciergesAsChatUserId] = $searchmessagesarray;
				}
				else
				{
					$finalChatListArray[$conciergesAsChatUserId] = $searchmessagesarray;
				}

			}

			$data['chatLists'] = $finalChatListArray;

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

			$viewData = view('chat.rendersidebar', $data)->render();

			return json_encode(array('status'=>1,'data'=>$viewData));
		}
		else
		{
			return json_encode(array('status'=>0,'data'=> 'No Users Found'));
		}
	}

	public function chatListing(Request $request)
	{
		$rules = array(
			'company_id' => 'required|numeric',
		);
		
		$input=$request->all();
		
		$conciergesOnline = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
		])
		->where('livestatus', 'active')
		->orderBy('id', 'desc')
		->get();

		$conciergesOffline = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
		])
		->where('livestatus', 'inactive')
		->orderBy('id', 'desc')
		->get();
		
		///// Online Concierges Lists Start /////
		
		$onlineConciergesIds = [];
		foreach ($conciergesOnline as $conkey => $conciergesOn) 
		{
			$onlineConciergesIds[$conkey] = $conciergesOn->email;
		}

		$conciergesAsChatUserIds = AppUsers::select('id')
		->whereIn('email', $onlineConciergesIds)
		->pluck('id')->toArray();

		$finalChatListArray = [];
		foreach ($conciergesAsChatUserIds as $key => $conciergesAsChatUserId) 
		{
			$messagesarray = Messages::leftjoin('app_users', 'app_users.id', '=', 'messages.receiver_id')
			->where('sender_id',$conciergesAsChatUserId)->groupBy('receiver_id')
			->where('app_users.user_type','resident')
			->orderBy('messages.created_at', 'ASC')
			->get();
			$finalChatListArray[$conciergesAsChatUserId] = $messagesarray;
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

	public function chatSidebarslide(Request $request)
	{
		$concierge = Concierges::where('id',$request->Concierge_id)->first();
		$appConciergeUser = AppUsers::where('email',$concierge->email)->first();
		
		$concierges_id = $appConciergeUser->id;
		$name = $appConciergeUser->first_name.' '.$appConciergeUser->last_name;
		
		$conciergesAsChatUserIds = AppUsers::select('id')
		->where('email', $concierge->email)
		->pluck('id')->toArray();

		$finalChatListArray = [];
		foreach ($conciergesAsChatUserIds as $key => $conciergesAsChatUserId) 
		{
			$messagesarray = Messages::leftjoin('app_users', 'app_users.id', '=', 'messages.receiver_id')
			->where('sender_id',$conciergesAsChatUserId)->groupBy('receiver_id')
			->where('app_users.user_type','resident')
			->get();
			$finalChatListArray[$conciergesAsChatUserId] = $messagesarray;
		}

		$data['chatLists'] = $finalChatListArray;


		$input=$request->all();

		$conciergesOnline = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
		])
		->where('livestatus', 'active')
		->orderBy('id', 'desc')
		->get();

		$conciergesOffline = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
		])
		->where('livestatus', 'inactive')
		->orderBy('id', 'desc')
		->get();


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


		$viewData = view('chat.rendersidebar', $data)->render();
		
		return json_encode(array('status'=>1,'data'=>$viewData,'concierges'=>$name));
	}
}
