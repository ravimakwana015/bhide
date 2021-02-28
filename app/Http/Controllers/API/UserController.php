<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Visitors;
use App\Models\UnitIssueRequest;
use App\Models\Parcels;
use App\Models\MessageBoard;
use App\Models\Messages;
use App\Models\Concierges;
use App\Models\CompanySettings;
use App\Models\Feeds;
use App\Models\Appnotifications;
use App\Models\AppUsers;
use App\Models\Agents;
use App\Mail\ForgotPasswordOtp;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Http\Controllers\Controller;

class UserController extends ResponseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $user = AppUsers::where('email', $request->email)->first();
            if (isset($user)) {
                if (Hash::check($request->password, $user->password)) {
                    $success['token'] = $user->createToken('MyApp')->accessToken;
                    $success['user'] = $user;
                    return response()->json(['success' => $success], 200);
                } else {
                    return response()->json(['error' => 'Your details do not match our records'], 422);
                }
            } else {
                return response()->json(['error' => 'Please check your email address'], 422);
            }
        }
    }

    public function updatelogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $user = AppUsers::where('email', $request->email)->first();
            if (isset($user)) {
                if ($request->password == $user->password) {
                    $success['token'] = $user->createToken('MyApp')->accessToken;
                    $success['user'] = $user;
                    return response()->json(['success' => $success], 200);
                } else {
                    return response()->json(['error' => 'Your details do not match our records'], 422);
                }
            } else {
                return response()->json(['error' => 'Please check your email address'], 422);
            }
        }
    }

    public function emergencyContact(Request $request)
    {
        $settings = CompanySettings::where('company_id', $request->company_id)->first();
        $emergency_numbers = json_decode($settings->emergency_numbers, true);
        $emergency_captions = json_decode($settings->emergency_captions, true);
        if (isset($settings) && count($emergency_numbers)) {
            $numbers = [];
            foreach ($emergency_numbers as $key => $val) {
                $numbers[] = [
                    'label' => $emergency_captions[$key],
                    'number' => $val,
                ];
            }
            return response()->json(['data' => $numbers], 200);
        } else {
            return response()->json(['error' => 'Emergency Numbers Not Found'], 422);
        }
    }
    public function home(Request $request)
    {
        $master = [];
        $master['parcels'] = Parcels::where([
            'company_id' => $request->company_id,
            'status' => 0,
            'unit_id' => $request->unit_id,
        ])->count();
        $master['messageCount'] = Messages::where('company_id', $request->company_id)
        ->where('receiver_id', $request->user_id)
        ->where('read_at',NULL)
        ->count();
        
        $master['visitors'] = Visitors::where('visitors.company_id', $request->company_id)
        ->where('visitors.unit_id', $request->unit_id)
        ->leftjoin('gates as g', 'g.id', '=', 'visitors.gate_id')
        ->leftjoin('units as u', 'visitors.unit_id', '=', 'u.id')
        ->leftjoin('reason_for_visits as rv', 'visitors.reason_id', '=', 'rv.id')
        ->select([
            'visitors.*',
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
            'g.id as cid',
            'g.name as gate_name',
            'rv.reason',
        ])
        ->orderBy('id', 'desc')
        ->take(2)
        ->get();
        $endTime = Carbon::parse(date('H:i'))->addHour(8);

        // $master['concierge'] = Concierges::where('concierges.company_id', $request->company_id)
        // ->whereTime('shift_end', '>=', date('H:i'))
        // ->whereTime('shift_end', '<=', date('H:i', strtotime($endTime)))
        // ->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
        // ->select([
        //     'concierges.*',
        //     DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
        //     'g.id as cid',
        //     'g.name as gate_name',
        // ])
        // ->orderBy('id', 'desc')
        // ->get();

        $conciergesOnline = Concierges::where('concierges.company_id', $request->company_id)
        ->select([
            'concierges.*',
            DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
        ])
        ->where('livestatus', 'active')
        ->orderBy('id', 'desc')
        ->get();

        $master['concierge'] = $conciergesOnline;

        // $master['messageBoard'] = MessageBoard::where('company_id', $request->company_id)
        // ->where('status', 1)
        // ->where('notice_valid_until', ">=", date('y-m-d'))
        // ->orderBy('id', 'desc')
        // ->take(5)
        // ->get();
        $master['messageBoard'] = Feeds::where('company_id', $request->company_id)
        ->where('description','!=','')
        ->orderBy('id', 'desc')
        ->take(5)
        ->get();
        $master['issue'] = UnitIssueRequest::where('company_id', $request->company_id)
        ->where('unit_id', $request->unit_id)
        ->where('user_id', $request->user_id)
        ->orderBy('id', 'desc')
        ->first();
        if (isset($master)) {
            return response()->json(['data' => $master], 200);
        } else {
            return response()->json(['error' => 'Data Not Found'], 422);
        }
    }

    public function saveDeviceToken(Request $request)
    {
        AppUsers::where('company_id', $request->company_id)
        ->where('id', $request->user_id)->update([
            'deviceToken' => $request->deviceToken
        ]);
        return response()->json(['data' => null], 200);
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 422);
    //     } else {
    //         $input = $request->all();
    //         $input['password'] = bcrypt($input['password']);
    //         $user = User::create($input);
    //         $success['token'] = $user->createToken('MyApp')->accessToken;
    //         $success['name'] = $user->name;
    //         return response()->json(['success' => $success], 200);
    //     }
    // }

    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $input = $request->all();
            $userData = AppUsers::where([['email', $request->email]])->first();
            if ($userData) {
                $otp = rand(123456, 10000);
                $userData->update(['OTP' => $otp]);
                Mail::to($userData->email)->send(new ForgotPasswordOtp($userData, $otp));
                return response()->json(['msg' => "We sent you a OTP on your email", 'data' => '', 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'No User Available with this Email', 'data' => null, 'success' => false], 422);
            }
        }
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed|different:old_password',
            'password_confirmation' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $userData = AppUsers::where('id', $request->id)->first();
        if ($userData) {
            
            if (Hash::check($request->get('old_password'), $userData->password)) 
            {
                $userData->update([
                    'password' => bcrypt($request->get('password')),
                    'OTP' => null
                ]);
                return response()->json(['msg' => "Password Change", 'success' => true], 200);
            }
            else
            {   
                return response()->json(['msg' => 'Old Password does not match', 'data' => null, 'success' => false], 422);
            }

        } else {
            return response()->json(['msg' => 'Given Data is invalid.', 'data' => null, 'success' => false], 422);
        }
    }
    public function updateUserDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $userData = AppUsers::where('email', $request->email)->first();

        if(!empty($request->file('images')))
        {
            $file = $request->file('images');
            $extension = $file->getClientOriginalExtension();
            $name = time().'.'.$file->extension();
            $file->move(public_path().'/front/member_image/', $name);
            // $imageName = time().'.'.request()->member_image->getClientOriginalExtension();
            // request()->member_image->move(public_path('front/member_image'), $imageName);
        }

        if(isset($userData)) {
            if(isset($name))
            {
                $userData->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'middle_name' => $request->middle_name,
                    'phone_number' => $request->phone_number,
                    'member_image' => $name,
                ]);
            }
            else
            {
                $userData->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'middle_name' => $request->middle_name,
                    'phone_number' => $request->phone_number,
                ]);
            }
            return response()->json(['msg' => "User Details Updated", 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'User Not Found', 'data' => null, 'success' => false], 422);
        }
    }

    public function showNotification(Request $request)
    {
        // $userNotifications = Appnotifications::where('company_id', $request->company_id)->orderBy('id', 'desc')->paginate(10);
        // if(isset($userNotifications)) {
        //     return response()->json(['data' => $userNotifications], 200);
        // } else {
        //     return response()->json(['msg' => 'Notifications Not Found', 'data' => null, 'success' => false], 422);
        // }

        $userNotifications = Appnotifications::where('company_id', $request->company_id)->orderBy('id', 'desc')->get();

        $group = array();

        foreach ( $userNotifications as $value ) {
            $group[$value->notification_date]['formatdate'] = Carbon::parse($value['notification_date'])->format('d M');
            $group[$value->notification_date]['items'][] = $value;
        }
        
        if(isset($group)) {
            return response()->json(['data' => $group], 200);
        } else {
            return response()->json(['msg' => 'Notifications Not Found', 'data' => null, 'success' => false], 422);
        }
        
    }

    public function deleteNotification(Request $request)
    {
        $rules = array(
            'company_id' => 'required|numeric',
            'notification_id' => 'required|numeric',
        );
        $messages = [
            
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all());
        }
        $input=$request->all();
        $notes=Appnotifications::where('company_id',$input['company_id'])->where('id',$input['notification_id'])->first();
        if(isset($notes)){
            $notes->delete();
            $success['message'] = 'Notification Deleted successful';
            return $this->sendResponse($success);
        }else{
            $error = 'Notification Not available';
            return $this->sendError($error, 401);
        }
    }

    public function getAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $agent = Agents::where('agents.company_id', $request->company_id)
        ->leftjoin('companies as g', 'g.id', '=', 'agents.company_id')
        ->select([
            'agents.*',
            'g.company_name',
        ])
        ->orderBy('id', 'desc')
        ->get();

        if(isset($agent)) {            
            return response()->json(['data' => $agent], 200);
        } else {
            return response()->json(['msg' => 'Agents Not Found', 'data' => null, 'success' => false], 422);
        }
    }

    

public function getUserDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'company_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        } else {
            $user = AppUsers::where('email', $request->email)
            ->where('company_id', $request->company_id)->first();
             //echo "--> ".$hashed = $user->password;
             // echo "--> ".$hashed = Hash::make("12345678");
             //echo "--> ".var_dump(Hash::check("12345678", $hashed)); die;
            if (isset($user)) {
                unset($user['password']);
                unset($user['deviceToken']);
                unset($user['OTP']);
                $success['user'] = $user;
                return response()->json(['success' => $success], 200);
            } else {
                
                
                return response()->json(['error' => 'Your details is not match with our records'], 422);
            }
            
        }
    }
    

}