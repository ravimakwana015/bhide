<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Models\Visitors;
use App\Models\Units;
use App\Models\UnitIssueRequest;
use App\Models\Services;
use App\Models\Polls;
use App\Models\Parcels;
use App\Models\MessageBoard;
use App\Models\LoyaltyCard;
use App\Models\Facilities;
use App\Models\EmergencyAlarmsResponse;
use App\Models\EmergencyAlarm;
use App\Models\Concierges;
use App\Models\Features;
use App\Models\Pages;
use App\Models\Contacts;
use App\Models\AppUsers;
use App\Models\Settings;
use App\Mail\ContactMail;
use App\Admin;
use App\Http\Controllers\NotificationController;

class HomeController extends Controller
{

    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        if(Auth::user())
        {
            return redirect()->route('home');
        }
        else
        {
            return view('welcome');
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $master = [];
        $master['issue'] = UnitIssueRequest::where('company_id', Auth::user()->company->id)->whereDate('created_at', Carbon::today())->count();
        $master['appUsers'] = AppUsers::where('company_id', Auth::user()->company->id)->count();
        $master['units'] = Units::where('company_id', Auth::user()->company->id)->count();
        $master['concierges'] = Concierges::where('company_id', Auth::user()->company->id)->count();
        $master['parcels'] = Parcels::where('company_id', Auth::user()->company->id)->whereDate('created_at', Carbon::today())->count();



        $query = UnitIssueRequest::where('company_id', Auth::user()->company->id);
        $date = Carbon::now();
        if (isset($request->issue) && $request->issue == 'month') {
            $query = $query->whereDate('created_at', '>=', $date->subDays(30));
        } else if (isset($request->issue) && $request->issue == 'year') {
            $query = $query->whereDate('created_at', '>=', $date->subDays(365));
        } else {
            $query = $query->whereDate('created_at', Carbon::today());
        }
        $master['todayIssue'] = $query->orderBy('id', 'desc')->limit(5)->get();

        $master['counttodayIssue'] = $query->get();

        $master['countservices'] = Services::where('company_id', Auth::user()->company->id)->get();
        $master['countvisitors'] = Visitors::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc')->paginate(10);
        $master['countmessageBoard'] = MessageBoard::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc')->paginate(10);
        $master['countparcels'] = Parcels::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc')->paginate(10);

        $master['services'] = Services::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc')->limit(5)->get();
        $master['visitors'] = Visitors::leftJoin('reason_for_visits', 'visitors.reason_id', '=', 'reason_for_visits.id')
        ->where('visitors.company_id', Auth::user()->company->id)->orderBy('visitors.id', 'desc')->limit(5)->get();
        $master['messageBoard'] = MessageBoard::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc')->limit(5)->get();

        $master['allparcels'] = Parcels::where('parcels.company_id', Auth::user()->company->id)
        ->leftjoin('units as u', 'parcels.unit_id', '=', 'u.id')
        ->select([
            'parcels.*',
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
        ])->orderBy('id', 'desc')->limit(5)->get();

        $settings = Settings::first();
        if($settings->dashboard_view == 1)
        {
            return view('home', compact('master'));
        }
        else
        {
            return view('home_new', compact('master'));
        }
    }

    public function sendEmergencyAlarm(Request $request, NotificationController $notification)
    {
        $input = $request->all();
        $this->validate($request, [
            'description' => 'required',
        ]);
        $input['company_id'] = Auth::user()->company->id;
        $appUsers = AppUsers::all();
        if (count($appUsers)) {
            $deviceTokens = [];
            $response = EmergencyAlarm::create($input);
            foreach ($appUsers as $user) {
                EmergencyAlarmsResponse::create([
                    'alarm_id' => $response->id,
                    'user_id' => $user->id,
                ]);
                if ($user->deviceToken != '') {
                    $deviceTokens[] = $user->deviceToken;
                }
            }
            if (count($deviceTokens) > 0) {
                try {
                    $title = "Emergency Alarm";
                    $body = $input['description'];
                    $type = 'emergency';
                    $res = $notification->senNotification($deviceTokens, $body, $title, $type,$response->id);
                    if ($res['status'] == 1) {
                        return response()->json(['msg' => 'Emergency Alarm Set Successfully'], 200);
                    } else {
                        return response()->json(['msg' => 'Emergency Alarm Set Successfully. Firebase Server Key No Available. Please Contact your Admin!!'], 200);
                    }
                } catch (\Throwable $th) {
                    throw $th;
                }
            } else {
                return response()->json(['msg' => 'Emergency Alarm Set Successfully'], 200);
            }
        } else {
            return response()->json(['msg' => 'No Members Are Available in Units'], 422);
        }
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function showNotification()
    {
        $userNotifications = Auth::user()->notifications()->paginate(10);
        return view('notifications', compact('userNotifications'));
    }

    /**
     * @return RedirectResponse
     */
    public function readNotification()
    {
        $notification = auth()->user()->unreadNotifications;
        foreach ($notification as $key => $value) {
            $id = $value->id;
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return redirect()->route('show.all.notification');
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function markAsReadNotification(Request $request)
    {
        $id = $request->all()['id'];
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return json_encode(array('status' => true));
    }

    public function deleteNotification($id)
    {
        DB::table('notifications')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Notifications Deleted Successfully !!');
    }

    public function features($value='')
    {
        $features = Features::orderBy('id','desc')->get();
        return view('features.index',compact('features'));  
    }

    public function dynamicPage($slug)
    {
        $normal = str_replace('-', ' ', $slug);
        $data['pages'] = Pages::where('title',$normal)->get();
        return view('dynamic', $data);
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactstore(Request $request)
    {
        $input = $request->all();
        
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'company' => 'required',
        ]);
        
        Contacts::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'company' => $input['company'],
            'message' => $input['message'],
        ]);

        $email = Admin::pluck('email')->first();
        
        Mail::to($email)->send(new ContactMail($input));

        return redirect()->route('user.contactus')->with('success', 'Mail Send Successfully!!');
        
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        DB::table("notifications")->whereIn('id',explode(",",$ids))->delete();
        return response()->json(['success'=>"Notifications Deleted successfully."]);
    }


}
