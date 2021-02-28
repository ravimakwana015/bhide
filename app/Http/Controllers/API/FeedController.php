<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AppUsers;
use App\Models\UserFeedsLikes;
use Auth;
use Validator;
use App\Models\UserFeed;
use App\Models\Feeds;
use DB;
use App\Models\UserFeedComments;
use App\Http\Controllers\API\ResponseController as ResponseController;

class FeedController extends ResponseController
{	
	/**
     * Associated Repository Model.
     */
	protected $upload_path;
	protected $storage;

    /**
     *
     */

    /**
     *
     */
    public function __construct(AppUsers $model)
    {
    	$this->model = $model;

    	$this->upload_path = 'front'.DIRECTORY_SEPARATOR.'feed_images'.DIRECTORY_SEPARATOR;

    	$this->storage = Storage::disk('public');
    }

    public function index(Request $request)
    {
    	$feeds = Feeds::where('company_id', $request->company_id)->orderBy('id', 'desc')->paginate(10);
    	if (isset($feeds)) {
    		return response()->json(['data' => $feeds], 200);
    	} else {
    		return response()->json(['error' => 'feeds Not Found'], 422);
    	}
    }

	/**
   * Add User Status.
   *
  **/
	public function addUserStatus(Request $request)
	{
		$input=$request->all();

		if(empty($input['user_feed_image']) && empty($input['feed']) ) {
			$error = 'Please Enter Something';
			return $this->sendError($error, 401);
		}
		if (isset($input['user_feed_image']) && !empty($input['user_feed_image']))
		{	
			$rules = array(
				'user_feed_image' => 'image|mimes:jpeg,png,jpg|max:2000'
			);
			$messages = [
				'user_feed_image.mimes' => 'Only jpeg,png and jpg images are allowed',
				'user_feed_image.max' => 'Sorry! Maximum allowed size for an image is 2MB'
			];
			$validator = Validator::make($request->all(), $rules,$messages);
			if ($validator->fails())
			{
				return $this->sendError($validator->errors()->all());
			}
		}
		else
		{
			$rules = array(
				
			);
			$messages = [
				
			];
		}

		$validator = Validator::make($request->all(), $rules,$messages);

		if ($validator->fails())
		{
			return $this->sendError($validator->errors()->all());
		}
		else
		{
			$input['user_id']=Auth::id();
			// $input['user_id']=$request->user_id;

			$input['feed_type']='status';
			$fileName = '';
			if (isset($input['user_feed_image']) && !empty($input['user_feed_image']))
			{
				$image=$input['user_feed_image'];

				$fileName = time().$image->getClientOriginalName();

				$this->storage->put($this->upload_path.$fileName, file_get_contents($image->getRealPath()));
				$input['properties'] = json_encode(['image' => $fileName]);
			}
			$feed=Feeds::create($input);

			$message=' Update New Status';
			

			$success['message'] = 'Status Added successful';
			$success['feed'] = $feed;
			$success['image'] = $fileName;
			return $this->sendResponse($success);
		}
	}

	/**
   * Delete user Status.
   *
  **/
	public function deletePost(Request $request)
	{
		$rules = array(
			'feed_id' => 'required|numeric',
		);
		$messages = [
			'feed_id.required' => 'Feed Id field is required'
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) {
			return $this->sendError($validator->errors()->all());
		}
		$input=$request->all();
		$feed=Feeds::where('id',$input['feed_id'])->first();
		if(isset($feed)){
			$feed->delete();
			$success['message'] = 'Feed Deleted successful';
			return $this->sendResponse($success);
		}else{
			$error = 'Feed Not available';
			return $this->sendError($error, 401);
		}
	}
	/**
   * get user Feed.
   *
  **/
	public function getPost(Request $request)
	{
		$rules = array(
			'feed_id' => 'required|numeric',
		);
		$messages = [
			'feed_id.required' => 'Feed Id field is required'
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) {
			return $this->sendError($validator->errors()->all());
		}
		$input=$request->all();

		$feed = Feeds::where('company_id', $input['company_id'])
		->where('id', $input['feed_id'])
		->select([
			'feeds.*',
			DB::raw("(SELECT COUNT(user_feeds_likes.feed_id)  FROM user_feeds_likes WHERE user_feeds_likes.feed_id=feeds.id) as likesCount"),
			DB::raw("(SELECT COUNT(user_feed_comments.feed_id)  FROM user_feed_comments WHERE user_feed_comments.feed_id=feeds.id) as commentsCount"),
            // DB::raw('count(g.feed_id) as likeCount, g.feed_id')
		])
		->first();


		if (!empty($feed)) 
		{
					// foreach ($feed as $key => $singleFeeds) 
					// {
			$datatat = json_decode($feed->properties);

			$property_array = [];
			if (!empty($datatat->image)) 
			{
				foreach ($datatat->image as $image_key => $image_value) {

					if(!empty($image_value))
					{
						$property_array[] = url('public/front/feed_images/').'/'.$image_value;
					}
					else
					{

					}

					// $property_array[] = url('public/front/feed_images/').'/'.$image_value;
				}   
			}

			$feed->properties = $property_array;

					// }
		}


		// $feed=Feeds::find($input['feed_id']);
		if(isset($feed)){
			// $success[]['likesCount']=UserFeedsLikes::where('feed_id',$input['feed_id'])->count();
			// $success[]['commentsCount']=UserFeedComments::where('feed_id',$input['feed_id'])->count();
			$success[]['feed'] = $feed;
			return $this->sendResponse($success);
		}else{
			$error = 'Feed Not available';
			return $this->sendError($error, 401);
		}
	}

	/**
   * get user Status.
   *
  **/
	public function updatePost(Request $request)
	{
		$input=$request->all();

		$rules = array(
			'feed_id' => 'required|numeric',
			'company_id' => 'required|numeric',
		);
		$messages = [
			'feed_id.required' => 'Feed Id field is required'
		];

		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) 
		{
			return $this->sendError($validator->errors()->all());
		}
		else
		{
			$feed=Feeds::find($input['feed_id']);

			if(isset($feed))
			{
				if(empty($input['user_feed_image']))
				{
					if(isset($input['deleted_images']))
					{
						if(!is_array($input['deleted_images']))
						{
							$imagesArray = explode(',',$input['deleted_images']);

							$existedimages = json_decode($feed->properties);
							$arryexistedimages = $existedimages->image;

							$resultMain = array();
							foreach ($arryexistedimages as $arryexistedimageskey => $arryexistedimagesvalue){

								if(!in_array($arryexistedimagesvalue, $imagesArray))
								{
									$resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
								}
							}
							$stringArray = implode(",",$resultMain);
							$Arraystring = explode(',', $stringArray);
							$resultArrays = json_encode(['image' => $Arraystring]);

							Feeds::where('id',$input['feed_id'])->update([
								'properties'=>$resultArrays
							]);
						}
					}
				}
				
				if (isset($input['user_feed_image']) && !empty($input['user_feed_image']))
				{   
					
					$rules = array(
						'user_feed_image[]' => 'image|mimes:jpeg,png,jpg'
					);
					$messages = [
						'user_feed_image[].mimes' => 'Only jpeg,png and jpg images are allowed',
						'user_feed_image[].max' => 'Sorry! Maximum allowed size for an image is 2MB'
					];
					$validator = Validator::make($request->all(), $rules,$messages);
					if ($validator->fails())
					{
						return $this->sendError($validator->errors()->all());
					}

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


						if(isset($input['deleted_images']) && !empty($input['deleted_images']))
						{
							if(!is_array($input['deleted_images']))
							{
								$imagesArray = explode(',',$input['deleted_images']);


								$existedimages = json_decode($feed->properties);
								$arryexistedimages = $existedimages->image;

								$resultMain = array();
								foreach ($arryexistedimages as $arryexistedimageskey => $arryexistedimagesvalue){

									if(!in_array($arryexistedimagesvalue, $imagesArray))
									{
										$resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
									}
								}
								$stringArray = implode(",",$resultMain);
								$Arraystring = explode(',', $stringArray);

							}
						}
						

						if(isset($Arraystring))
						{
							$allMergeArray = array_merge($Arraystring,$fileName);
							$input['properties'] = json_encode(['image' => $allMergeArray]);
						}
						else
						{
							$existedimages = json_decode($feed->properties);
							$arryexistedimages = $existedimages->image;
							if(isset($arryexistedimages))
							{
								$allMergeArray = array_merge($arryexistedimages,$fileName);
								$input['properties'] = json_encode(['image' => $allMergeArray]);
							}
							else
							{
								$input['properties'] = json_encode(['image' => $fileName]);
							}
						}
					}

					if(isset($input['description']))
					{
						$feed->update([
							'description' =>  $input['description'],
							'properties' =>  $input['properties'],
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					else
					{
						$feed->update([
							//'description' =>  $input['description'],
							'properties' =>  $input['properties'],
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					

				}
				else
				{
					if(isset($input['description']))
					{
						$feed->update([
							'description' =>  $input['description'],
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					else
					{
						$feed->update([
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					
				}

				$feed=Feeds::find($input['feed_id']);
				if (!empty($feed)) 
				{
					
					$datatat = json_decode($feed->properties);
					
					$property_array = [];
					if (!empty($datatat->image)) 
					{
						foreach ($datatat->image as $image_key => $image_value) {
							
							if(!empty($image_value))
							{
								$property_array[] = url('public/front/feed_images/').'/'.$image_value;
							}
							else
							{

							}
						}   
					}

					$feed->properties = $property_array;

				}
				
				$success[]['feed'] = $feed;
				return $this->sendResponse($success);
			}
			else
			{
				$error = 'Feed Not available';
				return $this->sendError($error, 401);
			}
		}
	}
	/**
   * Like Network Friend Status.
   *
  **/
	public function likePost(Request $request)
	{
		$rules = array(
			'feed_id' => 'required',
		);
		$messages = [
			'feed_id.required' => 'Feed Id field is required',
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails())
		{
			return $this->sendError($validator->errors()->all());
		}
		$input=$request->all();
		$input['user_id']=Auth::id();

		$feed=Feeds::find($input['feed_id']);
		if(isset($feed)){
			$alreadyLikes=UserFeedsLikes::where('feed_id',$input['feed_id'])->where('user_id',$input['user_id'])->first();
			if(isset($alreadyLikes)){
				$error = 'You already likes this Feed';
				return $this->sendError($error, 401);
			}
			$feed=UserFeedsLikes::create($input);
			$likes=UserFeedsLikes::where('feed_id',$input['feed_id'])->count();


			//$username=str_replace(' ', '-', strtolower(Auth::user()->username));
			//$msg='<a href="'.url('profile-details/'.$username).'">'.Auth::user()->first_name.' '.Auth::user()->last_name.' Like Your Status </a>';
			//$subject=Auth::user()->first_name.' '.Auth::user()->last_name.' Like Your Status';
			//$friendUser=$feed->post->postOwner;
			//$when = now()->addMinutes(2);

			// if($friendUser->id!=Auth::user()->id){
			// 	$friendUser->notify((new FriendRequestNotification($msg,$subject,Auth::user())));
			// }

			$success[]['message'] = "Feed Like successful";
			$success[]['likesCount'] = $likes;
			return $this->sendResponse($success);
		}else{
			$error = 'Feed Not available';
			return $this->sendError($error, 401);
		}
	}

	/**
   * Dislike Network Friend Status.
   *
  **/
	public function disLikePost(Request $request)
	{
		$rules = array(
			'feed_id' => 'required',
		);
		$messages = [
			'feed_id.required' => 'Feed Id field is required',
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails())
		{
			return $this->sendError($validator->errors()->all());
		}
		$input=$request->all();
		$feed=Feeds::find($input['feed_id']);
		if(isset($feed)){

			$feed=UserFeedsLikes::where('feed_id',$input['feed_id'])->where('user_id',Auth::id())->delete();
			// $feed=UserFeedsLikes::where('feed_id',$input['feed_id'])->where('user_id',$input['user_id'])->delete();
			$likes=UserFeedsLikes::where('feed_id',$input['feed_id'])->count();

			$success[]['message'] = "Feed disLike successful";
			$success[]['likesCount'] = $likes;
			return $this->sendResponse($success);
		}else{
			$error = 'Feed Not available';
			return $this->sendError($error, 401);
		}
	}

	/**
   * Add Comment on User Post.
   *
  **/
	public function postComment(Request $request)
	{
		$rules = array(
			'comment' => 'required',
			'feed_id' => 'required|numeric',
		);
		$messages = [
			'comment.required' => 'Please Write Your Comment',
			'feed_id.required' => 'Feed Id field is required'
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) {
			return $this->sendError($validator->errors()->all());
		}else{
			$input=$request->all();
			$input['user_id']=Auth::id();
			// $input['user_id']=$input['user_id'];
			$feed=Feeds::where('id','=',$input['feed_id'])->first();

			if(isset($feed)){
				$feedcomment=UserFeedComments::create($input);
				$message=' Commented on Your Status';
				// if(isset(Auth::user()->friendsOfMineNetwork) &&  count(Auth::user()->friendsOfMineNetwork))
				// {
				// 	$this->sendNetworkNotification(Auth::user()->friendsOfMineNetwork,$message);
				// }
				// if(isset(Auth::user()->friendOfNetwork) &&  count(Auth::user()->friendOfNetwork))
				// {
				// 	$this->sendNetworkNotification(Auth::user()->friendOfNetwork,$message);
				// }
				
				$comment=UserFeedComments::where('feed_id',$input['feed_id'])->count();

				$success[]['feedcomment'] = $feedcomment;
				// $success[]['commentdata'] = $commentData;
				$success[]['commentsCount'] = $comment;
				return $this->sendResponse($success);
			}else{
				$error = 'Feed Not available';
				return $this->sendError($error, 401);
			}
		}
	}

	public function getComment(Request $request)
	{
		$rules = array(
			'feed_id' => 'required|numeric',
		);
		$messages = [
			'feed_id.required' => 'Feed Id field is required'
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) {
			return $this->sendError($validator->errors()->all());
		}
		$input=$request->all();

		$feed = UserFeedComments::leftjoin('app_users as c', 'c.id', '=', 'user_feed_comments.user_id')
		->select([
			'user_feed_comments.*',
			DB::raw('CONCAT(c.first_name," ",c.last_name) AS username'),
		])
		->where('feed_id',$input['feed_id'])->get();

		if(isset($feed)){
			$success[]['feed'] = $feed;
			return $this->sendResponse($success);
		}else{
			$error = 'Comments Not available';
			return $this->sendError($error, 401);
		}
	}

	public function updatePosts(Request $request)
	{
		$input=$request->all();

		$rules = array(
			'feed_id' => 'required|numeric',
			'company_id' => 'required|numeric',
			// 'description' => 'required',
		);
		$messages = [
			// 'description.required' => 'Please Write Your Status',
			'feed_id.required' => 'Feed Id field is required'
		];
		$validator = Validator::make($request->all(), $rules,$messages);
		if ($validator->fails()) {
			return $this->sendError($validator->errors()->all());
		}else{
			$feed=Feeds::find($input['feed_id']);
			if(isset($feed)){

				if(isset($input['user_feed_image']) && !empty($input['user_feed_image']))
				{
					$explodeArray = explode(',',$input['deleted_images']);

					$imagesArray = [];
					foreach ($explodeArray as $explodekey => $explodevalue) {
						$pathinfo = pathinfo($explodevalue);
						$imagesArray[] = $pathinfo['filename'].'.'.$pathinfo['extension'];
					}

					$existedimages = json_decode($feed->properties);
					$arryexistedimages = $existedimages->image;
					
					$resultMain = array();
					foreach ($arryexistedimages as $arryexistedimageskey => $arryexistedimagesvalue){
						
						if(!in_array($arryexistedimagesvalue, $imagesArray))
						{
							$resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
						}
					}
					$stringArray = implode(",",$resultMain);
					$Arraystring = explode(',', $stringArray);
					$resultArrays = json_encode(['image' => $Arraystring]);

					Feeds::where('id',$input['feed_id'])->update([
						'properties'=>$resultArrays
					]);
				}
				else
				{

					$explodeArray = explode(',',$input['deleted_images']);

					$imagesArray = [];
					foreach ($explodeArray as $explodekey => $explodevalue) {
						$pathinfo = pathinfo($explodevalue);
						$imagesArray[] = $pathinfo['filename'].'.'.$pathinfo['extension'];
					}

					$existedimages = json_decode($feed->properties);
					$arryexistedimages = $existedimages->image;
					
					$resultMain = array();
					foreach ($arryexistedimages as $arryexistedimageskey => $arryexistedimagesvalue){
						
						if(!in_array($arryexistedimagesvalue, $imagesArray))
						{
							$resultMain[$arryexistedimageskey]=$arryexistedimagesvalue;
						}
					}
					$stringArray = implode(",",$resultMain);
					$Arraystring = explode(',', $stringArray);
					$resultArrays = json_encode(['image' => $Arraystring]);

					Feeds::where('id',$input['feed_id'])->update([
						'properties'=>$resultArrays
					]);
				}

				if (isset($input['user_feed_image']) && !empty($input['user_feed_image']))
				{   
					// if(!empty($feed->properties))
					// {
					// 	Feeds::where('id',$input['feed_id'])
					// 	->update([
					// 		'properties' => '',
					// 	]);
					// }
					$rules = array(
						'user_feed_image[]' => 'image|mimes:jpeg,png,jpg'
					);
					$messages = [
						'user_feed_image[].mimes' => 'Only jpeg,png and jpg images are allowed',
						'user_feed_image[].max' => 'Sorry! Maximum allowed size for an image is 2MB'
					];
					$validator = Validator::make($request->all(), $rules,$messages);
					if ($validator->fails())
					{
						return $this->sendError($validator->errors()->all());
					}

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

					if(isset($input['description']))
					{
						$feed->update([
							'description' =>  $input['description'],
							'properties' =>  $input['properties'],
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					else
					{
						$feed->update([
							//'description' =>  $input['description'],
							'properties' =>  $input['properties'],
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					

				}
				else
				{
					if(isset($input['description']))
					{
						$feed->update([
							'description' =>  $input['description'],
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					else
					{
						$feed->update([
							'company_id' =>  $input['company_id'],
							'feed_type' =>  'status',
						]);
					}
					
				}

				$feed=Feeds::find($input['feed_id']);
				$feeds->properties = ' ';
				$success[]['feed'] = $feed;
				return $this->sendResponse($success);
			}else{
				$error = 'Feed Not available';
				return $this->sendError($error, 401);
			}
		}
	}

}
