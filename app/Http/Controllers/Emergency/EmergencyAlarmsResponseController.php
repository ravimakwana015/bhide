<?php

namespace App\Http\Controllers\Emergency;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Units;
use App\Models\EmergencyAlarmsResponse;
use App\Models\EmergencyAlarm;
use App\Http\Controllers\Controller;

class EmergencyAlarmsResponseController extends Controller
{
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
        return view('emergency-response.index', compact('flats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmergencyAlarmsResponse  $emergencyAlarmsResponse
     * @return \Illuminate\Http\Response
     */
    public function show(EmergencyAlarmsResponse $emergencyAlarmsResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmergencyAlarmsResponse  $emergencyAlarmsResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(EmergencyAlarmsResponse $emergencyAlarmsResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmergencyAlarmsResponse  $emergencyAlarmsResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmergencyAlarmsResponse $emergencyAlarmsResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmergencyAlarmsResponse  $emergencyAlarmsResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmergencyAlarmsResponse $emergencyAlarmsResponse)
    {
        //
    }

    public function getEmergencyResponse(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($emergency) {
                return Carbon::parse($emergency->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($emergency) {
                return Carbon::parse($emergency->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('status', function ($emergency) {
                if ($emergency->emeStatus == 0) {
                    return '<label class="btn btn-warning btn-xs">Unsafe</label>';
                } else  if ($emergency->emeStatus == 1) {
                    return '<label class="btn btn-success btn-xs">Safe</label>';
                }
            })
            // ->addColumn('actions', function ($emergency) {
            //     $actions = '<a title="Edit Visitor" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('emergency.edit', $emergency->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            //     </a>  <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("emergency.destroy", $emergency) . '" id="delete_' . $emergency->id . '" onclick="deletePopup(' . $emergency->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            //     return $actions;
            // })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = EmergencyAlarm::where('emergency_alarms.company_id', Auth::user()->company->id)
            ->leftjoin('emergency_alarms_responses as res', 'res.alarm_id', '=', 'emergency_alarms.id')
            ->leftjoin('app_users as u', 'u.id', '=', 'res.user_id')
            ->leftjoin('units as un', 'un.id', '=', 'u.unit_id')
            ->select([
                'emergency_alarms.*',
                'res.note as note',
                'res.status as emeStatus',
                'res.response_date as response_date',
                DB::raw('CONCAT(u.first_name," ",u.last_name) AS name'),
                DB::raw('CONCAT(un.block_number,"-",un.flat_number) AS unit'),
            ])->orderBy('id', 'desc');
        if (isset($input['unit']) && $input['unit'] != '') {
            $dataTableQuery->where('u.unit_id', '=', $input['unit']);
        }
        return  $dataTableQuery;
    }
}
