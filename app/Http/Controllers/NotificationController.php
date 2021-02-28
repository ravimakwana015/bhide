<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Appnotifications;
use Carbon\Carbon;
use Auth;

class NotificationController extends Controller
{
    public function senNotification($tokenList, $body, $title,$type,$alarm_id='')
    {
        $settings = Settings::first();
        if (isset($settings->firebase_server_key) && $settings->firebase_server_key != '') {

            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

            $notification = [
                "body" => $body,
                "title" => $title,
                'sound' => true,
            ];

            $extraNotificationData = ["type" => $type,'alarm_id' => $alarm_id];

            $fcmNotification = [
                'registration_ids' => $tokenList,
                'notification' => $notification,
                'data' => $extraNotificationData
            ];

            Appnotifications::create([
                'company_id' => Auth::user()->company->id,
                'data' => $notification['body'],
                'type' => $extraNotificationData['type'],
                'notification_date' => Carbon::now(),
            ]);
            
            $headers = [
                'Authorization: key=' . $settings->firebase_server_key . '',
                'Content-Type: application/json'
            ];


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);

            curl_close($ch);

            return [
                'status' => 1,
                'data' => $result
            ];
        } else {
            return [
                'status' => 0,
                'msg' => 'Firebase Server Key No Available. Please Contact your Admin!!'
            ];
        }
    }


    public function apiNotification($tokenList, $body, $title,$type,$company_id,$alarm_id='')
    {
        $settings = Settings::first();
        if (isset($settings->firebase_server_key) && $settings->firebase_server_key != '') {

            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

            $notification = [
                "body" => $body,
                "title" => $title,
                'sound' => true,
            ];

            $extraNotificationData = ["type" => $type,'alarm_id' => $alarm_id];

            $fcmNotification = [
                'registration_ids' => $tokenList,
                'notification' => $notification,
                'data' => $extraNotificationData
            ];

            Appnotifications::create([
                'company_id' => $company_id,
                'data' => $notification['body'],
                'type' => $extraNotificationData['type'],
                'notification_date' => Carbon::now(),
            ]);
            
            $headers = [
                'Authorization: key=' . $settings->firebase_server_key . '',
                'Content-Type: application/json'
            ];


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);

            curl_close($ch);

            return [
                'status' => 1,
                'data' => $result
            ];
        } else {
            return [
                'status' => 0,
                'msg' => 'Firebase Server Key No Available. Please Contact your Admin!!'
            ];
        }
    }
}
