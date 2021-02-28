<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\EmergencyAlarmResponse;
use App\Models\EmergencyAlarmsResponse;
use App\Models\EmergencyAlarm;
use App\Models\Company;
use App\Models\AppUsers;
use App\Http\Controllers\Controller;

class EmergencyAlarmController extends Controller
{
    public function emergencyMessages(Request $request){
        $emergencyMessages = EmergencyAlarm::where('company_id',$request->company_id)->orderBy('id', 'desc')->paginate(10);
        if (isset($emergencyMessages)) {
            return response()->json(['data' => $emergencyMessages], 200);
        } else {
            return response()->json(['error' => 'Emergency Messages Not Found'], 422);
        }
    }

    public function safeUnsafeStatusUpdate(Request $request)
    {
        $input = $request->all();
        $note = '';
        if ($input['status'] == 0) {
            $validator = Validator::make($request->all(), [
                'note' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            $note = $input['note'];
        }

        $alarm = EmergencyAlarmsResponse::where('alarm_id', $request->alarm_id)
            ->where('user_id', $request->user_id)->first();
        if (isset($alarm)) {
            $alarm->update([
                'status'        => $input['status'],
                'note'          => $note,
                'response_date' => date('Y-m-d H:i:s')
            ]);
            $company = Company::where('id', $request->company_id)->first();
            $companyUser = User::where('id', $company->user_id)->first();
            $appUser = AppUsers::where('id', $request->user_id)->first();
            $msg = '';
            if ($input['status'] == 0) {
                $msg = $appUser->first_name . ' ' . $appUser->last_name . ' is not safe help him/her';
            }else{
                $msg = $appUser->first_name . ' ' . $appUser->last_name . ' is safe';
            }
            $companyUser->notify(new EmergencyAlarmResponse($appUser, $msg));
            return response()->json(['success' => 1], 200);
        } else {
            return response()->json(['error' => "Alarm Not Found"], 422);
        }
    }
}
