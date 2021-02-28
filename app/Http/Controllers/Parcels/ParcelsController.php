<?php

namespace App\Http\Controllers\Parcels;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Units;
use App\Models\Parcels;
use App\Models\AppUsers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class ParcelsController extends Controller
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

        $this->site_logo_path = 'img' . DIRECTORY_SEPARATOR . 'parcel' . DIRECTORY_SEPARATOR;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Apartment';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('parcels.index', compact('flats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Unit';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('parcels.create', compact('flats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotificationController $notification)
    {

        $input = $request->except('_token', '_method');

        $this->validate($request, [
            'unit_id' => 'required',
            'total_parcel' => 'required|numeric',
        ]);
        // if (isset($input['image']) && !empty($input['image'])) {
        //     $logo = $input['image'];
        //     $image_name = time() . $logo->getClientOriginalName();
        //     Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
        //     $input['image'] = $image_name;
        // }
        $input['company_id'] = Auth::user()->company->id;
        Parcels::create($input);
        //Push notification
        // return redirect()->route('parcels.index')->with('success', 'Parcels Added Successfully!!');
        $deviceTokens = getDeviceTokens($input['unit_id']);
        if (count($deviceTokens)) {
            try {
                $title = 'Parcels Arrived';
                $body = 'Parcels arrived for you unit, please collect';
                $type = 'parcel';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return response()->json(['status' => 1, 'msg' => 'Parcels Added Successfully!!']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Parcels Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(['status' => 1, 'msg' => 'Parcels Added Successfully!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parcels  $parcels
     * @return \Illuminate\Http\Response
     */
    public function show(Parcels $parcels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parcels  $parcels
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parcel = Parcels::find($id);
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Unit';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        // return view('parcels.edit', compact('parcel', 'flats'));
        $editService = view('parcels.edit_modal', compact('parcel', 'flats'))->render();
        return response()->json(['status' => 1, 'html' => $editService]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parcels  $parcels
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, NotificationController $notification)
    {
        $parcel = Parcels::find($id);
        $input = $request->except('_token', '_method');

        $input['updated_at'] = Carbon::now();

        $this->validate($request, [
            'total_parcel' => 'required|numeric',
            'unit_id' => 'required',
        ]);
        $parcel->update($input);
        $deviceTokens = getDeviceTokens($input['unit_id']);
        if (count($deviceTokens) > 0 && $input['status'] == 1) {
            try {
                $title = 'Parcels Collected';
                $body = 'Parcels Collected Successfully';
                $type = 'parcel';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return redirect()->route('parcels.index')->with('success', 'Parcels updated Successfully!!');
                } else {
                    return redirect()->route('parcels.index')->with('success', 'Parcels updated Successfully. Firebase Server Key No Available. Please Contact your Admin!!');
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return redirect()->route('parcels.index')->with('success', 'Parcels updated Successfully!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parcels  $parcels
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Parcels::find($id)->delete();
        return redirect()->route('parcels.index')->with('success', 'Parcels deleted Successfully!!');
    }

    public function getParcels(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($parcels) {
            return Carbon::parse($parcels->created_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('updated_at', function ($parcels) {
            return Carbon::parse($parcels->updated_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('total_parcel', function ($parcels) {

            $totalparcelsof = Parcels::where('parcels.company_id', Auth::user()->company->id)->where('unit_id',$parcels->unit_id)->sum('total_parcel');

            return $details = '<a title="Parcels Details" href="javascript:;" onclick="parcelsDetails(' . $parcels->unit_id . ')" > <span class="ul-btn__icon"> '.$totalparcelsof.' </span>
            </a>';
        })
        ->editColumn('status', function ($facilities) {
            if ($facilities->status == 0) {
                return '<label class="btn btn-warning btn-xs">Pending</label>';
            } else  if ($facilities->status == 1) {
                return '<label class="btn btn-success btn-xs">Collected</label>';
            }
        })
        ->addColumn('actions', function ($parcels) {
            $actions = '<a title="Edit Parcels" class="btn btn-sm btn-outline-primary btn-icon" href="javascript:;" data-url="' . route('parcels.edit', $parcels->id) . '" id="edit_' . $parcels->id . '" onclick="editPopup(' . $parcels->id . ')" > <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a>  <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("parcels.destroy", $parcels) . '" id="delete_' . $parcels->id . '" onclick="deletePopup(' . $parcels->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            return $actions;
        })
        ->rawColumns(['actions', 'image', 'status','total_parcel'])
        ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Parcels::where('parcels.company_id', Auth::user()->company->id)
        ->leftjoin('units as u', 'parcels.unit_id', '=', 'u.id')
        ->select([
            'parcels.*',
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
        ])->orderBy('id', 'desc')->groupBy('parcels.unit_id');

        return  $dataTableQuery;
    }

    public function getPollUsers(Request $request)
    {
        $input = $request->all();
        $poll = Parcels::where('parcels.company_id', Auth::user()->company->id)->where('unit_id',$input['id'])->get();
        
        $users_name = [];
        foreach ($poll as $key => $value) {

            if($value->status == 0)
            {
                $status = 'Pending';
            }
            else
            {
                $status = 'Collected By';
            }

            $users_name[] = 'Parcels '.$value->total_parcel.' -- '.$status.' '.$value->name;
        }
        $html = view('parcels.poll_result_users',compact('users_name'))->render();
        return response()->json(['status' => '1','result'=>$html]);
        
    }

}
