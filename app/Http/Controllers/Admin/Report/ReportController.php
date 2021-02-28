<?php

namespace App\Http\Controllers\Admin\Report;

use Yajra\DataTables\Facades\DataTables;
use Session;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Units;
use App\Models\Services;
use App\Models\Parcels;
use App\Models\Facilities;
use App\Models\Company;
use App\Models\AppUsers;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
	public function userReports()
	{
		$users = DB::table('app_users')->
		leftjoin('companies as c','c.id','=','app_users.company_id')
		->selectRaw('MONTH(app_users.created_at) AS month,YEAR(app_users.created_at) AS year,app_users.city as city_name,app_users.city as city_name,c.company_name')->get()->toarray();

		$months=[];
		$year=[];
		$company_name=[];
		$city_name=[];
		foreach ($users as $key => $value) {
			$months[$value->month]=$value->month;
			$year[$value->year]=$value->year;
			$company_name[$value->company_name]=$value->company_name;
			$city_name[$value->city_name]=$value->city_name;
		}

		return view('admin.reports.user-reports',compact('months','year','company_name','city_name'));
	}

	public function getData(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($appUser) {
            return Carbon::parse($appUser->created_at)->format('d/m/Y h:i:s A');
        })->editColumn('company_name', function ($appUser) {
			return '<a href="' . route('companies.show', $appUser->company_id) . '" >' . $appUser->company_name . '</a> ';
		})
        ->editColumn('updated_at', function ($appUser) {
            return Carbon::parse($appUser->updated_at)->format('d/m/Y h:i:s A');
        })->filterColumn('name', function ($dataTableQuery, $keyword) {
            $keywords = trim($keyword);
            $dataTableQuery->whereRaw("CONCAT(app_users.last_name, app_users.first_name) like ?", ["%{$keywords}%"]);
        })
        // <a title="View User" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('apartment.show', $appUser->id) . '"> <span class="ul-btn__icon"><i class="fas fa-eye"></i></span>
        //     </a>
        ->addColumn('actions', function ($appUser) {
            $actions = '
            <button type="button" class="btn btn-outline-info" onclick="getData('.$appUser->id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Page"><i class="fas fa-user-edit"></i></button>

            </a> <a class="btn btn-danger" href="' . route("send_login_details_admin", $appUser->id) . '"  title="Send Login Details"><span class="ul-btn__icon"><i class="fas fa-paper-plane"></i></span></a> <button type="button" class="btn btn-outline-danger" onclick="getDelete('.$appUser->id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Page"><i class="fas fa-trash"></i></button>';
            return $actions;
        })
        ->rawColumns(['status', 'actions','company_name'])
        ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = AppUsers::leftjoin('companies as c', 'c.id', '=', 'app_users.company_id')
        ->leftjoin('units as u', 'app_users.unit_id', '=', 'u.id')
        ->select([
            'app_users.*',
            DB::raw('CONCAT(app_users.last_name," ",app_users.first_name) AS name'),
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit_name'),
            'c.id as cid',
            'c.company_name',
        ])
        ->orderBy('id', 'desc');

        if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('c.id',$input['company_name']);
        }

        return  $dataTableQuery;
    }

}
