<?php

namespace App\Http\Controllers\Admin\Parcel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Services;
use App\Models\Units;
use App\Models\Parcels;
use Session;
use DB;

class ParcelDataTablesController extends Controller
{
    public function getData(Request $request)
     {
     	return Datatables::make($this->getForDataTable($request->all()))
     	->escapeColumns(['id'])
     	->editColumn('created_at', function ($parcels) {
     		return Carbon::parse($parcels->created_at)->format('d/m/Y H:i:s');
     	})
     	->editColumn('company_name', function ($parcels) {
     		return '<a href="' . route('companies.show', $parcels->company_id) . '" >' . $parcels->company_name . '</a> ';
     	})
     	->editColumn('unit_name', function ($parcels) {
     		return ''.$parcels->block_number.'-'.$parcels->flat_number.'';
     	})
     	->editColumn('status', function ($parcels) {
     		if ($parcels->parcels_status == 1) {
     			return '<label class="btn btn-success btn-xs">Collected</label>';
     		} else  if ($parcels->parcels_status == 0) {
     			return '<label class="btn btn-danger btn-xs">Pending</label>';
     		}
     	})->addColumn('actions', function ($parcels) { 
     		return '<button type="button" class="btn btn-outline-info" onclick="getData('.$parcels->parcels_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Parcel"><i class="fas fa-user-edit"></i></button>   
     		<button type="button" class="btn btn-outline-danger" onclick="getDelete('.$parcels->parcels_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Parcel"><i class="fas fa-trash"></i></button>';
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
    	$dataTableQuery = Parcels::leftJoin('companies', 'parcels.company_id', '=', 'companies.id')
    	->leftJoin('units', 'parcels.unit_id', '=', 'units.id')
    	->select([
    		'companies.person_name',
    		'companies.company_name',
    		'companies.id as company_id',
    		'units.block_number as block_number',
    		'units.flat_number as flat_number',
    		'parcels.id as parcels_id',
    		'parcels.total_parcel',
    		'parcels.name',
    		'parcels.status as parcels_status',
    		'parcels.created_at',
    	]);

    	if (isset($input['month']) && $input['month'] != '') {
    		$dataTableQuery->whereMonth('parcels.created_at', '=', $input['month']);
    	}

    	if (isset($input['year']) && $input['year'] != '') {
    		$dataTableQuery->whereYear('parcels.created_at', '=', $input['year']);
    	}

    	if (isset($input['from_date']) && isset($input['to_date']) && $input['from_date'] != '' && $input['to_date'] != '') {
    		$dataTableQuery->whereBetween('parcels.created_at', array($input['from_date'], $input['to_date']));
    	}

    	if (isset($input['status']) && $input['status'] != '') {
    		$dataTableQuery->where('payment_status', '=', $input['status']);
    	}

        if (isset($input['company_name']) && $input['company_name'] != '') {
            $dataTableQuery->where('companies.id',$input['company_name']);
        }

    	return $dataTableQuery;
    }
}
