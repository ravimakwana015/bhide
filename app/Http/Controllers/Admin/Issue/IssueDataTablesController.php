<?php

namespace App\Http\Controllers\Admin\Issue;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\Facilities;
use App\Models\UnitIssueRequest;
use App\Models\Company;
use App\Models\Units;
use App\Models\AppUsers;
use App\User;

class IssueDataTablesController extends Controller
{
   public function getData(Request $request)
     {
     	return Datatables::make($this->getForDataTable($request->all()))
     	->escapeColumns(['id'])
     	->editColumn('created_at', function ($unit_issue_requests) {
     		return Carbon::parse($unit_issue_requests->created_at)->format('d/m/Y H:i:s');
     	})
     	->editColumn('company_name', function ($unit_issue_requests) {
     		return '<a href="' . route('companies.show', $unit_issue_requests->company_id) . '" >' . $unit_issue_requests->company_name . '</a> ';
     	})
     	->editColumn('unit_name', function ($unit_issue_requests) {
     		return ''.$unit_issue_requests->block_number.'-'.$unit_issue_requests->flat_number.'';
     	})
     	->editColumn('app_user_name', function ($unit_issue_requests) {
     		return ''.$unit_issue_requests->first_name.' '.$unit_issue_requests->middle_name.' '.$unit_issue_requests->last_name.'';
     	})
     	->editColumn('status', function ($unit_issue_requests) {
     		if ($unit_issue_requests->unit_issue_requests_status == 1) {
     			return '<label class="btn btn-success btn-xs">Done</label>';
     		} else  if ($unit_issue_requests->unit_issue_requests_status == 2) {
     			return '<label class="btn btn-info btn-xs">In Review</label>';
     		}else  if ($unit_issue_requests->unit_issue_requests_status == 0) {
     			return '<label class="btn btn-danger btn-xs">Pending</label>';
     		}
     	})
     	->make(true);
     }

    /**
     * getForDataTable
     *
     * @return void
     */
    public function getForDataTable($input)
    {
    	$dataTableQuery = UnitIssueRequest::leftJoin('companies', 'unit_issue_requests.company_id', '=', 'companies.id')
    	->leftJoin('units', 'unit_issue_requests.unit_id', '=', 'units.id')
    	->leftJoin('app_users', 'unit_issue_requests.user_id', '=', 'app_users.id')
    	->select([
    		'companies.person_name',
    		'companies.company_name',
    		'companies.id as company_id',
    		'app_users.first_name as first_name',
    		'app_users.middle_name as middle_name',
    		'app_users.last_name as last_name',
    		'units.block_number as block_number',
    		'units.flat_number as flat_number',
    		'unit_issue_requests.id as unit_issue_requests_id',
    		'unit_issue_requests.issue',
    		'unit_issue_requests.status as unit_issue_requests_status',
    		'unit_issue_requests.created_at',
    	]);

        if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('companies.id',$input['company_name']);
        }
    	if (isset($input['month']) && $input['month'] != '') {
    		$dataTableQuery->whereMonth('unit_issue_requests.created_at', '=', $input['month']);
    	}

    	if (isset($input['year']) && $input['year'] != '') {
    		$dataTableQuery->whereYear('unit_issue_requests.created_at', '=', $input['year']);
    	}

    	if (isset($input['from_date']) && isset($input['to_date']) && $input['from_date'] != '' && $input['to_date'] != '') {
    		$dataTableQuery->whereBetween('unit_issue_requests.created_at', array($input['from_date'], $input['to_date']));
    	}

    	if (isset($input['status']) && $input['status'] != '') {
    		$dataTableQuery->where('payment_status', '=', $input['status']);
    	}
    	return $dataTableQuery;
    }
}
