<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AppUsers;
use App\Models\UserFeedsLikes;
use App\Models\UserFeedComments;
use Auth;
use App\Models\Feeds;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use URL;
use DB;
use App\Http\Controllers\API\ResponseController as ResponseController;

class FeedsController extends ResponseController
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $feeds = Feeds::where('company_id', $request->company_id)
        ->select([
            'feeds.*',
            DB::raw("(SELECT COUNT(user_feeds_likes.feed_id)  FROM user_feeds_likes WHERE user_feeds_likes.feed_id=feeds.id) as likesCount"),
            DB::raw("(SELECT COUNT(user_feed_comments.feed_id)  FROM user_feed_comments WHERE user_feed_comments.feed_id=feeds.id) as commentsCount"),
            DB::raw("(SELECT member_image FROM app_users WHERE app_users.id=1) as userimage"),
        ])
        ->orderBy('id', 'desc')->paginate(10);

        if (!empty($feeds)) 
        {
            foreach ($feeds as $key => $singleFeeds) 
            {
                $datatat = json_decode($feeds[$key]->properties);
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

                $feeds[$key]->properties = $property_array;

                $likeUsersId = UserFeedsLikes::where('user_feeds_likes.feed_id',$singleFeeds->id)->get('user_id')->toArray();

                $likeUsersIdArr = [];
                foreach ($likeUsersId as $likeUsersIdkey => $likeUsersIdvalue) 
                {
                    $likeUsersIdArr[] = $likeUsersIdvalue['user_id'];
                }

                $feeds[$key]->likeUserIds = $likeUsersIdArr;
                $feeds[$key]->userimage = 'https://demo.joykal.com/laravel/aptly/public/front/agent_image/1606733995.png';
            }
        }


        if (isset($feeds)) {
            return response()->json(['data' => $feeds], 200);
        } else {
            return response()->json(['error' => 'feeds Not Found'], 422);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,NotificationController $notification)
    {
        // $validator = Validator::make($request->all(), [
        //     'description' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 422);
        // } else {

        //     Feeds::create([
        //         'company_id' => $request->company_id,
        //         'user_id' => $request->user_id,
        //         'description' => $request->description,
        //     ]);
        //     return response()->json(['success' => true], 200);
        // }


        $input=$request->all();

        if(empty($input['user_feed_image']) && empty($input['description']) ) {
            $error = 'Please Enter Something';
            return $this->sendError($error, 401);
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
            // Log::write('event', $request->all());
            $input['user_id']=Auth::id();
            // $input['user_id']=$request->user_id;
            $input['company_id'] = $input['company_id'];
            $input['feed_type']='status';
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
                
                
                // $fileName = time().$image->getClientOriginalName();

                // 
            }

            if(isset($input['user_feed_image']))
            {

                if(isset($input['description']))
                {
                    $feed=Feeds::create([
                        'user_id' => Auth::id(),
                        'description' => $input['description'],
                        'company_id'  => $input['company_id'],
                        'properties'  => $input['properties'],
                        'feed_type'  => 'status'
                    ]);
                }
                else
                {
                    $feed=Feeds::create([
                        'user_id' => Auth::id(),
                        // 'description' => $input['description'],
                        'company_id'  => $input['company_id'],
                        'properties'  => $input['properties'],
                        'feed_type'  => 'status'
                    ]);
                }
            }
            else
            {
                $feed=Feeds::create($input);
            }
            
            $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
            if (count($deviceTokens) > 0) {
                try {
                    $title = 'New Feed Added';
                    $body = 'New Feed Available';
                    $type = 'feed';
                    $res = $notification->apiNotification($deviceTokens, $body, $title, $type,$request->company_id);
                    // return response()->json(['status' => 1, 'msg' => 'Service Added Successfully!!']);
                } catch (\Throwable $th) {
                    throw $th;
                }
            }

            $message=' Update New Status';
            

            $success['message'] = 'Feed Added successful';
            $success['feed'] = $feed;
            $success['image'] = $fileName;
            return $this->sendResponse($success);
        }



    }
}
