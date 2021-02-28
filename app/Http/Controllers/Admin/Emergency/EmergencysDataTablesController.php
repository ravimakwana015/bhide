<?php

namespace App\Http\Controllers\Admin\Emergency;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\Facilities;
use App\Models\UnitIssueRequest;
use App\Models\EmergencyAlarm;
use App\Models\Company;
use App\Models\Units;
use App\Models\AppUsers;
use App\User;
use DB;

class EmergencysDataTablesController extends Controller
{
	public function getData(Request $request)
	{
		return DataTables::make($this->getForDataTable($request->all()))
		->editColumn('created_at', function ($emergency) {
			return Carbon::parse($emergency->created_at)->format('d/m/Y h:i:s A');
		})
		->editColumn('response_date', function ($emergency) {
			return Carbon::parse($emergency->response_date)->format('d/m/Y h:i:s A');
		})
		->editColumn('company_name', function ($emergency) {
			return '<a href="' . route('companies.show', $emergency->company_id) . '" >' . $emergency->company_name . '</a> ';
		})
		->editColumn('updated_at', function ($emergency) {
			return Carbon::parse($emergency->updated_at)->format('d/m/Y h:i:s A');
		})
		->editColumn('status', function ($emergency) {
			if ($emergency->emergency_status == 0) {
				return '<label class="btn btn-warning btn-xs">Unsafe</label>';
			} else  if ($emergency->emergency_status == 1) {
				return '<label class="btn btn-success btn-xs">Safe</label>';
			}
		})
		->rawColumns(['status','company_name'])
		->make(true);
	}

	public function getForDataTable($input)
	{

		$dataTableQuery = EmergencyAlarm::leftjoin('emergency_alarms_responses as res', 'res.alarm_id', '=', 'emergency_alarms.id')
		->leftjoin('app_users as u', 'u.id', '=', 'res.user_id')
		->leftjoin('units as un', 'un.id', '=', 'u.unit_id')
		->leftjoin('companies as cn', 'cn.id', '=', 'emergency_alarms.company_id')
		->select([
			'emergency_alarms.*',
			'res.note as note',
			'res.status as emergency_status',
			'res.response_date as response_date',
			'cn.company_name',
			DB::raw('CONCAT(u.first_name," ",u.last_name) AS name'),
			DB::raw('CONCAT(un.block_number,"-",un.flat_number) AS unit'),
		])->orderBy('id', 'desc');
		if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('cn.id',$input['company_name']);
        }
		return  $dataTableQuery;
	}
}

