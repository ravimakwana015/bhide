<?php

namespace App\Http\Controllers\Admin\Facilitie;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\Facilities;

class FacilitieDataTablesController extends Controller
{
     /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function getData(Request $request)
     {
     	return Datatables::make($this->getForDataTable($request->all()))
     	->escapeColumns(['id'])
     	->editColumn('created_at', function ($facilities) {
     		return Carbon::parse($facilities->created_at)->format('d/m/Y H:i:s');
     	})
     	->editColumn('company_name', function ($facilities) {
     		return '<a href="' . route('companies.show', $facilities->company_id) . '" >' . $facilities->company_name . '</a> ';
     	})
     	->editColumn('status', function ($facilities) {
     		if ($facilities->facilities_status == 1) {
     			return '<label class="btn btn-success btn-xs">Active</label>';
     		} else  if ($facilities->facilities_status == 0) {
     			return '<label class="btn btn-danger btn-xs">Inactive</label>';
     		}
     	})->addColumn('actions', function ($facilities) { 
     		return '<button type="button" class="btn btn-outline-info" onclick="getData('.$facilities->facilities_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Facilitie"><i class="fas fa-user-edit"></i></button>   
     		<button type="button" class="btn btn-outline-danger" onclick="getDelete('.$facilities->facilities_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Facilitie"><i class="fas fa-trash"></i></button>';
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
    	$dataTableQuery = Facilities::leftJoin('companies', 'facilities.company_id', '=', 'companies.id')
    	->select([
    		'companies.person_name',
    		'companies.company_name',
    		'companies.id as company_id',
    		'facilities.id as facilities_id',
    		'facilities.facility_name',
    		'facilities.contact',
    		'facilities.availability',
    		'facilities.status as facilities_status',
    		'facilities.created_at',
    	]);

        if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('companies.id',$input['company_name']);
        }

    	if (isset($input['month']) && $input['month'] != '') {
    		$dataTableQuery->whereMonth('facilities.created_at', '=', $input['month']);
    	}

    	if (isset($input['year']) && $input['year'] != '') {
    		$dataTableQuery->whereYear('facilities.created_at', '=', $input['year']);
    	}

    	if (isset($input['from_date']) && isset($input['to_date']) && $input['from_date'] != '' && $input['to_date'] != '') {
    		$dataTableQuery->whereBetween('facilities.created_at', array($input['from_date'], $input['to_date']));
    	}

    	if (isset($input['status']) && $input['status'] != '') {
    		$dataTableQuery->where('payment_status', '=', $input['status']);
    	}
    	return $dataTableQuery;
    }
}
