<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CompanySettings;
use App\Models\Messages;
use App\Models\Company;
use App\Models\Concierges;
use App\Models\Feeds;
use App\Models\AppUsers;
use App\Models\UserFeedComments;
use App\Models\UserFeedsLikes;
use Validator;
use Carbon\Carbon;
use DB;
use URL;


class FeedController extends Controller
{
	public function index()
	{
		$user = Company::where('id', Auth::user()->company->id)->first();
		
		if (!isset($user)) {
			return redirect()->back()->with('error', 'Not a Valid Link');
		}
		if (Auth::user()) 
		{

			$feeds = Feeds::where('feeds.company_id', Auth::user()->company->id)
			->leftjoin('app_users', 'app_users.id', '=', 'feeds.user_id')
			->select([
				'feeds.*',
				'app_users.id as uid',
				'app_users.first_name',
				'app_users.last_name',
				'app_users.member_image',
				'feeds.id as feed_id',
			])
			// ->orderBy('feeds.created_at', 'desc')->get();
			->orderBy('feeds.created_at', 'desc')->paginate(10);

			$onlineConcierges = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
			])
			->where('livestatus', 'active')
			->orderBy('id', 'desc')
			->get();

			$offlineConcierges = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
			])
			->where('livestatus', 'inactive')
			->orderBy('id', 'desc')
			->get();

			if(!empty($onlineConcierges))
			{
				return view('feed.index', compact('feeds', 'user', 'onlineConcierges','offlineConcierges'));
			}
			else
			{
				return view('feed.index', compact('feeds', 'user'));
			}
		}
		else
		{
			return redirect() -> back() -> with('error', 'You can not see Feeds');
		}
	}

	public function addUserStatus(Request $request)
	{
		$input = $request -> all();
		
		if (empty($input['user_feed_image']) && empty($input['description'])) {
			return response()->json(array(
				'status' => false,
				'msg' => ['Please Enter Something']
			));
		}
		$rules = array(
			'user_feed_image[]' => 'image|mimes:jpeg,png,jpg|max:2000'
		);
		$messages = [
			'user_feed_image[].mimes' => 'Only jpeg,png and jpg images are allowed',
			'user_feed_image[].max' => 'Sorry! Maximum allowed size for an image is 2MB'
		];
		$validator = Validator::make($request -> all(), $rules, $messages);

		if ($validator->fails()) 
		{
			return response()->json(array(
				'status' => false,
				'msg' => $validator->errors()->all()
			));
		}
		else
		{
			$endTime = Carbon::parse(date('H:i'))->addHour(8);
			$concierge = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->whereTime('shift_start', '>=', date('H:i'))
			->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
			->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
				'g.id as cid',
				'g.name as gate_name',
			])
			->orderBy('id', 'desc')
			->first();

			if(!empty($concierge))
			{
				$appUsersId = AppUsers::where('email',$concierge->email)->first();
				if(isset($appUsersId))
				{
					$input['feed_type'] = 'status';
					$input['company_id'] = Auth::user()->company->id;
					$input['user_id'] = $appUsersId->id;
					$fileName = '';
					if (isset($input['user_feed_image']) && !empty($input['user_feed_image'])) 
					{
						$image=$input['user_feed_image'];

						$allowedfileExtension=['jpeg','jpg','png'];
						$files = $request->file('user_feed_image');


						$fileName = array();
						$i = 1;
						foreach ($request->file('user_feed_image') as $file) 
						{
							$extension = $file->getClientOriginalExtension();
							$check = in_array($extension,$allowedfileExtension);

							if($check) 
							{
								$url = URL::to("/");
								$name = time().$i.'.'.$file->extension();
								$fileName[] = $name;

								$file->move(public_path().'/front/feed_images/', $name);  
								$data[] = $name;

							}
							else
							{
								return response()->json(['invalid_file_format'], 422);
							}
							$i++;
						}

						$input['properties'] = json_encode(['image' => $fileName]);
					}

					if(isset($input['user_feed_image']))
					{
						if(isset($input['simple_id']))
						{
							$allGetfeed = Feeds::find($input['simple_id']);

							if(!empty($allGetfeed->properties))
							{
								$existedimages = json_decode($allGetfeed->properties);

								if(isset($input['properties']))
								{
									$inputsimages = json_decode($input['properties']);

									$existedresultMain = array();
									foreach ($existedimages->image as $arryexistedimageskey => $arryexistedimagesvalue){

										$existedresultMain[$arryexistedimageskey]=$arryexistedimagesvalue;

									}

									$inputsimagesMain = array();
									foreach ($inputsimages->image as $arryexistedimageskey => $arryexistedimagesvalue){

										$inputsimagesMain[$arryexistedimageskey]=$arryexistedimagesvalue;

									}

									$completeArray = array_merge($existedresultMain,$inputsimagesMain);

									$resultArrays = json_encode(['image' => $completeArray]);
								}
								else
								{
									$resultArrays = $allGetfeed->properties;
								}
								
							}
							

							if(isset($input['description']))
							{
								if(!empty($resultArrays))
								{
									$allGetfeed->update([
										'description' => $input['description'],
										'properties'  => $resultArrays,
									]);
								}
								else
								{
									$allGetfeed->update([
										'description' => $input['description'],
										'properties'  => $input['properties'],
									]);
								}
							}
							else
							{
								if(!empty($resultArrays))
								{
									$allGetfeed->update([
										'properties'  => $resultArrays,
									]);
								}
								else
								{
									$allGetfeed->update([
										'properties'  => $input['properties'],
									]);
								}
							}
						}
						else
						{
							if(isset($input['description']))
							{
								$feed=Feeds::create([
									'user_id' => $appUsersId->id,
									'description' => $input['description'],
									'company_id'  => Auth::user()->company->id,
									'properties'  => $input['properties'],
									'feed_type'  => 'status'
								]);
							}
							else
							{
								$feed=Feeds::create([
									'user_id' => $appUsersId->id,
									'company_id'  => Auth::user()->company->id,
									'properties'  => $input['properties'],
									'feed_type'  => 'status'
								]);
							}
						}
					}
					else
					{
						if(isset($input['simple_id']))
						{
							$allGetfeed = Feeds::find($input['simple_id']);

							if(!empty($allGetfeed->properties))
							{
								$existedimages = json_decode($allGetfeed->properties);

								if(isset($input['properties']))
								{
									$inputsimages = json_decode($input['properties']);

									$existedresultMain = array();
									foreach ($existedimages->image as $arryexistedimageskey => $arryexistedimagesvalue){

										$existedresultMain[$arryexistedimageskey]=$arryexistedimagesvalue;

									}

									$inputsimagesMain = array();
									foreach ($inputsimages->image as $arryexistedimageskey => $arryexistedimagesvalue){

										$inputsimagesMain[$arryexistedimageskey]=$arryexistedimagesvalue;

									}

									$completeArray = array_merge($existedresultMain,$inputsimagesMain);

									$resultArrays = json_encode(['image' => $completeArray]);
								}
								else
								{
									$resultArrays = $allGetfeed->properties;
								}
								
							}


							if(isset($input['description']))
							{
								if(!empty($resultArrays))
								{
									$allGetfeed->update([
										'description' => $input['description'],
										'properties'  => $resultArrays,
									]);
								}
								else
								{
									$allGetfeed->update([
										'description' => $input['description'],
										'properties'  => $input['properties'],
									]);
								}
							}
							else
							{
								if(!empty($resultArrays))
								{
									$allGetfeed->update([
										'properties'  => $resultArrays,
									]);
								}
								else
								{
									$allGetfeed->update([
										'properties'  => $input['properties'],
									]);
								}
							}


							// if(!empty($resultArrays))
							// {
							// 	$allGetfeed->update([
							// 		'properties'  => $resultArrays,
							// 	]);
							// }
							// else
							// {
							// 	$allGetfeed->update([
							// 		'properties'  => $input['properties'],
							// 	]);
							// }
						}
						else
						{
							$feed=Feeds::create([
								'user_id' => $appUsersId->id,
								'company_id'  => Auth::user()->company->id,
								'description' => $input['description'],
								'feed_type'  => 'status'
							]);
						}
					}

					$message = 'Updated their Status';

					return response()->json(array(
						'status' => true,
						//'feed' => $feed,
						//'image' => $fileName
					));
				}
				else
				{
					return response()->json(array(
						'status' => 'nocon',
						'msg' => 'No Concierges Available',
					));
				}
			}
			else
			{
				return response()->json(array(
					'status' => 'nocon',
					'msg' => 'No Concierges Available',
				));
			}
		}
	}

	public function postComment(Request $request)
	{
		$rules = array(
			'comment' => 'required',
		);
		$messages = [
			'comment.required' => 'Please Write Your Comment'
		];
		$validator = Validator::make($request -> all(), $rules, $messages);
		if ($validator->fails()) {
			return response() -> json(array(
				'status' => false,
				'msg' => $validator -> errors()
			));
		} else {
			$input = $request -> all();

			$endTime = Carbon::parse(date('H:i'))->addHour(8);
			$concierge = Concierges::where('concierges.company_id', Auth::user()->company->id)
			->whereTime('shift_start', '>=', date('H:i'))
			->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
			->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
			->select([
				'concierges.*',
				DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
				'g.id as cid',
				'g.name as gate_name',
			])
			->orderBy('id', 'desc')
			->first();

			if(!empty($concierge))
			{
				$appUsersId = AppUsers::where('email',$concierge->email)->first();
				$feedcomment = UserFeedComments::create([
					'feed_id' => $input['feed_id'],
					'user_id' => $appUsersId->id,
					'comment' => $input['comment']
				]);
				// $comment = UserFeedComments::where('feed_id', $input['feed_id'])->count();
				// return response() -> json(array(
				// 	'status' => true,
				// 	'feedcomment' => $feedcomment,
				// 	'commentdata' => $commentData,
				// 	'comment' => $comment
				// ));
			}
		}
	}


	/**
     * Like Network Friend Status.
     *
     * @param Request $request
     * @return JsonResponse
     */
	public function likePost(Request $request)
	{
		$input = $request -> all();
		$input['friend_id'] = Auth::id();
		$endTime = Carbon::parse(date('H:i'))->addHour(8);
		$concierge = Concierges::where('concierges.company_id', Auth::user()->company->id)
		->whereTime('shift_start', '>=', date('H:i'))
		->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
		->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
		->select([
			'concierges.*',
			DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
			'g.id as cid',
			'g.name as gate_name',
		])->orderBy('id', 'desc')
		->first();

		if(!empty($concierge))
		{
			$appUsersId = AppUsers::where('email',$concierge->email)->first();
			$feed = UserFeedsLikes::create([
				'feed_id' => $input['feed_id'],
				'user_id' => $appUsersId->id,
			]);
			$likes = UserFeedsLikes::where('feed_id', $input['feed_id'])->count();
			return response() -> json(array(
				'status' => true,
				'likes' => $likes
			));
		}
	}

    /**
     * Dislike Network Friend Status.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function disLikePost(Request $request)
    {
    	$input = $request->all();
    	$endTime = Carbon::parse(date('H:i'))->addHour(8);
    	$concierge = Concierges::where('concierges.company_id', Auth::user()->company->id)
    	->whereTime('shift_start', '>=', date('H:i'))
    	->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
    	->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
    	->select([
    		'concierges.*',
    		DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
    		'g.id as cid',
    		'g.name as gate_name',
    	])->orderBy('id', 'desc')
    	->first();

    	if(!empty($concierge))
    	{
    		$appUsersId = AppUsers::where('email',$concierge->email)->first();
    		$feed = UserFeedsLikes::where('feed_id', $input['feed_id'])->where('user_id',$appUsersId->id)->delete();
    		$likes = UserFeedsLikes::where('feed_id', $input)->count();
    		return response()->json(array(
    			'status' => true,
    			'likes' => $likes
    		));
    	}
    }

    public function deletePost(Request $request)
    {
    	$input = $request -> all();
    	$feed = Feeds::where('id', $input['id']) -> delete();
    	return response() -> json(array(
    		'status' => true
    	));
    }

    /**
     * get user Status.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPost(Request $request)
    {
    	$input = $request->all();

    	$feed = Feeds::find($input['id']);

    	if (isset($feed)) {
    		return response()->json(array(
    			'status' => true,
    			'feed' => $feed
    		));
    	} else {
    		return response() -> json(array(
    			'status' => false
    		));
    	}
    }

    /**
     * get user Status.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePost(Request $request)
    {
    	$input = $request -> all();

    	$rules = array(
    		'feed' => 'required',
    	);
    	$messages = [
    		'feed.required' => 'Please Write Your Status'
    	];
    	$validator = Validator::make($request -> all(), $rules, $messages);
    	if ($validator -> fails()) {
    		return response() -> json(array(
    			'status' => 3,
    			'msg' => $validator -> errors()
    		));
    	} else {
    		$feed = Feeds::find($input['feed_id']);

    		$feed -> update([
    			'description' => $input['feed']
    		]);
    		$feed = Feeds::find($input['feed_id']);
    		if (isset($feed)) {
    			return response() -> json(array(
    				'status' => true,
    				'feed' => $feed
    			));
    		} else {
    			return response() -> json(array(
    				'status' => false
    			));
    		}
    	}
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deletePostComment(Request $request)
    {
    	$input = $request-> all();
    	$feedcomment = UserFeedComments::find($input['id']);
    	$feedcomment->delete();
    	return response()->json(array('status' => 'true'));
    }

    public function deleteImages(Request $request)
    {
    	$input = $request->all();
    	$feedcomment = Feeds::find($input['post_id']);

    	$existedimages = json_decode($feedcomment->properties);

    	$arryexistedimages = $input['image_name'];

    	$resultMain = array();
    	foreach ($existedimages->image as $arryexistedimageskey => $arryexistedimagesvalue){
    		if($arryexistedimagesvalue != $arryexistedimages)
    		{
    			$resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
    		}
    	}

    	$stringArray = implode(",",$resultMain);
    	$Arraystring = explode(',', $stringArray);
    	$resultArrays = json_encode(['image' => $Arraystring]);
    	
    	Feeds::where('id',$input['post_id'])->update([
    		'properties'=>$resultArrays
    	]);

    	return response()->json(array('status' => 'true','delete'=> $input['delete_id']));
    }


    public function getConcierges(Request $request)
    {
    	$conciergesDetails = Concierges::where('concierges.company_id', Auth::user()->company->id)
    	->select([
    		'concierges.email',
    		'concierges.concierge_image',
    	])
    	->where('id',$request->concierge_id)
    	->first();

    	$conciergesAppUsersDetails = AppUsers::where('app_users.company_id', Auth::user()->company->id)
    	->where('email',$conciergesDetails->email)
    	->first();

    	$image = asset('public/front/concierges_image/'.$conciergesDetails->concierge_image);
    	
    	return response()->json(array(
    		'status' => true,
    		'image' => $image,
    		'data' => $conciergesAppUsersDetails,
    		'msg' => 'Online Choose Done',
    	));
    }

}
