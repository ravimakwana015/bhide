<?php

use App\Models\AppUsers;
use App\Models\UserFeedsLikes;
use App\Models\UserFeedComments;
use App\Models\Messages;
use Carbon\Carbon;

if (!function_exists('getDeviceTokens')) {
    function getDeviceTokens($unit_id)
    {
        return AppUsers::where('unit_id', $unit_id)
        ->where('deviceToken', '!=', '')
        ->pluck('deviceToken');
    }
}


if (!function_exists('userPostLike')) {

    function userPostLike($feed_id)
    {
        return UserFeedsLikes::where('user_feeds_likes.feed_id', $feed_id)->first();
    }
}

if (!function_exists('userPostLikeCount')) {

    function userPostLikeCount($feed_id)
    {
        return UserFeedsLikes::where('user_feeds_likes.feed_id', $feed_id)->count();
    }
}

if (!function_exists('userPostCommentCount')) {

    function userPostCommentCount($feed_id)
    {
        return UserFeedComments::where('feed_id', $feed_id)->count();
    }
}

if (!function_exists('userPostComments')) {

    function userPostComments($feed_id)
    {
        return UserFeedComments::leftjoin('app_users as u','u.id','=','user_feed_comments.user_id')->where('user_feed_comments.feed_id', $feed_id)->orderBy('created_at',
            'DESC')->get(array('user_feed_comments.*'));
    }
}

if (!function_exists('ChatCount')) {

    function ChatCount($concierge_id,$feed_id)
    {
        return Messages::where(function($query) use ($concierge_id,$feed_id)
        {
            $query->where('read_at',NULL)->where(['sender_id' =>$concierge_id, 'receiver_id' => $feed_id, 'company_id' => Auth::user()->company->id]);
        })->orWhere(function($query) use ($concierge_id,$feed_id)
        {
            // $query->where('read_at',NULL)->where(['sender_id' =>$feed_id, 'receiver_id' => $concierge_id, 'company_id' => Auth::user()->company->id ]);
        })->count();
        
    }
}

if (!function_exists('ChatLastMessage')) {
    function ChatLastMessage($concierge_id,$feed_id)
    {

        $data = Messages::where(function($query) use ($concierge_id,$feed_id)
        {
            $query->where(['sender_id' =>$concierge_id, 'receiver_id' => $feed_id, 'company_id' => Auth::user()->company->id ]);
        })->orWhere(function($query) use ($concierge_id,$feed_id)
        {
            $query->where(['sender_id' =>$feed_id, 'receiver_id' => $concierge_id, 'company_id' => Auth::user()->company->id ]);
        })->latest('created_at')->first();


        if(isset($data->created_at))
        {
            return Carbon::createFromTimeStamp(strtotime($data->created_at))->diffForHumans();
        }
        
    }
}

if (!function_exists('getOnlineStatus')) {

    function getOnlineStatus($shiftStart,$shiftEnd)
    {
        $midNightTime = "23:59:59";
        $todayDate = date("Y-m-d");
        $nexttDate = date("Y-m-d", strtotime(' +1 day'));
        
        $currentDate = $todayDate;
        $shiftStartDateTime = $currentDate. " " . $shiftStart;
        if (strtotime($shiftStart) > strtotime($shiftEnd) && strtotime($shiftEnd) < strtotime($midNightTime)) {
            $currentDate = $nexttDate;
        } 

        $shiftEndDateTime = $currentDate. " " . $shiftEnd;
        $shiftStartTime = strtotime($shiftStartDateTime);
        $shiftEndTime = strtotime($shiftEndDateTime);
        $currentTimeOnly = time();
        
        if($currentTimeOnly >= $shiftStartTime && $currentTimeOnly <= $shiftEndTime)
        {
            return 'active';
        }
        else
        {
            return 'inactive';
        }
    }
}

if (!function_exists('getUserName')) {

    function getUserName($app_usersId)
    {
        $result = DB::table('app_users')->select('first_name','last_name')->where('id', $app_usersId)->first();
        return $result->first_name.' '.$result->last_name;
    }
}
if (!function_exists('getUserId')) {

    function getUserId($app_usersId)
    {
        $result = DB::table('app_users')->select('id')->where('id', $app_usersId)->first();
        return $result->id;
    }
}

if (!function_exists('getUnitName')) {

    function getUnitName($app_usersId)
    {
        $resultApp = DB::table('app_users')->select('unit_id')->where('id', $app_usersId)->first();
        $result = DB::table('units')->select('block_number','flat_number')->where('id', $resultApp->unit_id)->first();

        return $result->block_number.'-'.$result->flat_number;
    }
}