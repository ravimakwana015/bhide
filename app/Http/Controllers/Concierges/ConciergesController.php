<?php

namespace App\Http\Controllers\Concierges;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Gates;
use App\Models\Concierges;
use App\Models\Units;
use App\Models\AppUsers;
use App\Models\ClockTimes;
use App\Http\Controllers\Controller;

class ConciergesController extends Controller
{
    /**
     * Site Logo Path.
     *
     * @var string
     */
    protected $site_logo_path;
    /**
     * Constructor.
     */
    public function __construct()
    {

        $this->site_logo_path = 'img' . DIRECTORY_SEPARATOR . 'concierge_image' . DIRECTORY_SEPARATOR;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('concierges.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gates = Gates::pluck('name', 'id')->toArray();
        return view('concierges.create', compact('gates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token', '_method');

        $this->validate($request, [
            'email' => 'required|unique:app_users',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required',
            'concierge_image' => 'required|image',
        ]);
        $logo = $input['concierge_image'];
        $image_name = time() . $logo->getClientOriginalName();
        Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
        // $input['concierge_image'] = $image_name;
        // $input['date_of_birth'] = date("Y-m-d", strtotime($input['date_of_birth']));
        // $input['company_id'] = Auth::user()->company->id;
        // $input['shift_start'] =  '10:00:00';
        // $input['shift_end'] =  '05:00:00';
        // $input['concierge_image'] =  $input['concierge_images'];

        

        $unit = Units::where('company_id',Auth::user()->company->id)->first();
        
        if(isset($unit))
        {
            Concierges::create([
                'gate_id' => $input['gate_id'],
                'company_id' => Auth::user()->company->id,
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'gender' => $input['gender'],
                'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
                'email' => $input['email'],
                'phone_number' => $input['phone_number'],
                'shift_start' => '10:00:00',
                'shift_end' => '05:00:00',
                'concierge_image' => $input['concierge_images'],
                'address' => $input['address'],
                'city' => $input['city'],
                'state' => $input['state'],
                'country' => $input['country'],
                'zip_code' => $input['zip_code'],
            ]);

            $registerConcierges = Concierges::where('email',$input['email'])->first();
            if(isset($registerConcierges))
            {
                $user = AppUsers::create([
                    'unit_id'    => $unit->id,
                    'company_id' => Auth::user()->company->id,
                    'password'   => bcrypt($input['first_name']),
                    'first_name' => $input['first_name'],
                    'last_name' => $input['last_name'],
                    'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
                    'member_type' => 'company',
                    'phone_number' => $input['phone_number'],
                    'member_image' => $input['concierge_images'],
                    'address' => $input['address'],
                    'city' => $input['city'],
                    'country' => $input['country'],
                    'zip_code' => $input['zip_code'],
                    'email' => $input['email'],
                    'user_type' => 'company',
                ]);
            }
        }
        else
        {
            return redirect()->route('units.index')->with('error', 'Please create Unit in Apartment First');
        }
        
        return redirect()->route('concierges.index')->with('success', 'Concierge Added Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Concierges  $concierges
     * @return \Illuminate\Http\Response
     */
    public function show(Concierges $concierges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Concierges  $concierges
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $concierge = Concierges::find($id);
        // $gates = Gates::where('company_id', Auth::user()->company->id)->pluck('name', 'id')->toArray();
        $gates = Gates::pluck('name', 'id')->toArray();
        return view('concierges.edit', compact('gates', 'concierge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Concierges  $concierges
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except('_token', '_method');
        $concierge = Concierges::find($id);
        $this->validate($request, [
            'email' => 'required|email|unique:concierges,email,' . $concierge->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required',
            'concierge_image' => 'sometimes|required|image',
        ]);
        if (isset($input['concierge_image'])) {
            $logo = $input['concierge_image'];
            $image_name = time() . $logo->getClientOriginalName();
            Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
            $input['concierge_image'] = $image_name;
        }
        $input['shift_start'] =  '10:00:00';
        $input['shift_end'] =  '05:00:00';

        if(isset($input['concierge_images']))
        {
            $concierge->update([
                'concierge_image' => $input['concierge_images'],
            ]);
        }
        else
        {
            $concierge->update([
                'concierge_image' => $concierge->concierge_image,
            ]);
        }

        $concierge->update([
            'gate_id' => $input['gate_id'],
            'company_id' => Auth::user()->company->id,
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'shift_start' => '10:00:00',
            'shift_end' => '05:00:00',
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'country' => $input['country'],
            'zip_code' => $input['zip_code'],
        ]);

        // $concierge->update($input);
        return redirect()->route('concierges.index')->with('success', 'Concierge updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Concierges  $concierges
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Concierges::find($id)->delete();
        return redirect()->route('concierges.index')->with('success', 'Concierge Deleted Successfully!!');
    }


    public function clockTime(Request $request)
    {
        $currentTime = Carbon::now();
        $now = $currentTime->toDateTimeString();

        $alreadyClockIn = ClockTimes::where('concierge_id',$request->concierge_id)->whereDate('start_time',Carbon::today())->where('end_time',NULL)->whereDate('created_at', Carbon::today())->orderBy('id','desc')->first();

        if(collect($alreadyClockIn)->isEmpty())
        {
            ClockTimes::create([
                'concierge_id' => $request->concierge_id,
                'start_time' => $now,
            ]);

            Concierges::where('id', $request->concierge_id)->update(['con_start_time' => $now , 'livestatus' => 'active','con_end_time' => NULL]);

            return response()->json(['status' => 1, 'msg' => 'Clock In - '.Carbon::parse($now)->format('h:i:s A').'', 'button'=>'Clock Out','newclass'=>'btn']);
        }
        else
        {
            ClockTimes::where('concierge_id', $request->concierge_id)->whereDate('created_at', Carbon::today())->update(['end_time' => $now]);

            Concierges::where('id', $request->concierge_id)->update(['con_end_time' => $now , 'livestatus' => 'inactive']);
            return response()->json(['status' => 0, 'msg' => 'You are currently clocked out', 'button'=>'Clock In','newclass'=>'btn btn-danger']);
        }

    }


    public function getConcierges(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($concierges) {
            return Carbon::parse($concierges->created_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('updated_at', function ($concierges) {
            return Carbon::parse($concierges->updated_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('gate', function ($concierges) {
            return $concierges->gate_name;
        })
        ->editColumn('concierge_image', function ($concierges) {
            return "<img src='" . asset('public/front/concierges_image/') . "/" . $concierges->concierge_image . "' width='80' height='80' id='career_img'>";
        })
        ->editColumn('shift', function ($concierges) {
            $start = trim(explode(':',$concierges->shift_start)[0]).":".trim(explode(':',$concierges->shift_start)[1]);
            $end = trim(explode(':',$concierges->shift_end)[0]).":".trim(explode(':',$concierges->shift_end)[1]);
            $timeString = $start. " TO ". $end;
            return $timeString;
        })
        ->addColumn('clock', function ($concierges) {
            if($concierges->livestatus == 'active')
            {
                $clockaction = '<div class="clock-wrap" data-url="'.route("clock") . '"><span class="ul-btn__icon"><i class="fas fa-clock"></i></span><span id="clock_' . $concierges->id . '">Clock In - '.Carbon::parse($concierges->con_start_time)->format('h:i:s A').'</span>
                <a class="btn" id="forclass_' . $concierges->id . '" href="javascript:;" onclick="clockstartend('.$concierges->id.')"> <span id="time_' . $concierges->id . '">Clock Out</span> </a>
                </div>';
            }
            else
            {
                if(isset($concierges->con_end_time))
                {
                    $clockaction = '<div class="clock-wrap" data-url="'.route("clock") . '"><span class="ul-btn__icon"><i class="fas fa-clock"></i></span><span id="clock_' . $concierges->id . '">You are currently clocked out</span>
                    <a class="btn btn-danger" id="forclass_' . $concierges->id . '" href="javascript:;" onclick="clockstartend('.$concierges->id.')"> <span id="time_' . $concierges->id . '">Clock In</span> </a>
                    </div>';
                }
                else
                {
                    $clockaction = '<div class="clock-wrap" data-url="'.route("clock") . '"><span class="ul-btn__icon"><i class="fas fa-clock"></i></span><span id="clock_' . $concierges->id . '">You are currently clocked out</span>
                    <a class="btn btn-danger" id="forclass_' . $concierges->id . '" href="javascript:;" onclick="clockstartend('.$concierges->id.')"> <span id="time_' . $concierges->id . '">Clock In</span> </a>
                    </div>';
                }
            }
            return $clockaction;
        })
        ->addColumn('actions', function ($concierges) {
            $actions = '<a title="Chat" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('chatparticular', $concierges->id) . '"> <span class="ul-btn__icon"><i class="fas fa-comment"></i></span>
            </a> <a title="Edit Visitor" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('concierges.edit', $concierges->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("concierges.destroy", $concierges) . '" id="delete_' . $concierges->id . '" onclick="deletePopup(' . $concierges->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            return $actions;
        })
        ->rawColumns(['actions', 'concierge_image', 'clock'])
        ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Concierges::where('concierges.company_id',Auth::user()->company->id)->leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
        ->select([
            'concierges.*',
            DB::raw('CONCAT(concierges.first_name," ",concierges.last_name) AS name'),
            'g.id as cid',
            'g.name as gate_name',
        ])->orderBy('id', 'desc');
        // if (isset($input['month']) && $input['month'] != '') {
        //     $dataTableQuery->whereMonth('created_at', '=', $input['month']);
        // }
        // if (isset($input['year']) && $input['year'] != '') {
        //     $dataTableQuery->whereYear('created_at', '=', $input['year']);
        // }
        // if (isset($input['from_date']) && isset($input['to_date']) && $input['from_date'] != '' && $input['to_date'] != '') {
        //     $dataTableQuery->whereBetween('created_at', array($input['from_date'], $input['to_date']));
        // }
        // if (isset($input['status']) && $input['status'] != '') {

        //     $dataTableQuery->where(function ($fq) use ($input) {
        //         if ($input['status'] == '7') {
        //             $fq->where('status', '=', '3')->orWhere('status', '=', '7');
        //         } else {
        //             $fq->where('status', '=', $input['status']);
        //         }
        //     });
        // }
        // if (isset($input['payment_status']) && $input['payment_status'] != '') {
        //     $dataTableQuery->where('payment_status', '=', $input['payment_status']);
        // }
        return  $dataTableQuery;
    }

    public function uploadConciergesIcon(Request $request)
    {
        $input = $request -> all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = public_path('front/concierges_image/').$image_name;
        //$path = '/public/front/building_image/'.$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }
}
