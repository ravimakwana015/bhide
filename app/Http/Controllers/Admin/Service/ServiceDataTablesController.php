<?php

namespace App\Http\Controllers\Admin\Service;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\Company;
use App\Http\Controllers\Controller;

class ServiceDataTablesController extends Controller
{
    /**
     * Process ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getData(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
        // ->escapeColumns(['id'])
        ->editColumn('created_at', function ($services) {
            return Carbon::parse($services->created_at)->format('d/m/Y H:i:s');
        })
        ->editColumn('company_name', function ($services) {
            return '<a href="">' . $services->company_name . '</a> ';
        })
        ->editColumn('status', function ($services) {
            if ($services->services_status == 1) {
                return '<label class="btn btn-success btn-xs">Open</label>';
            } else  if ($services->services_status == 0) {
                return '<label class="btn btn-danger btn-xs">Close</label>';
            }
        })->addColumn('actions', function ($services) { 
            return '<button type="button" class="btn btn-outline-info" onclick="getData('.$services->service_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Service"><i class="fas fa-user-edit"></i></button>   
                <button type="button" class="btn btn-outline-danger" onclick="getDelete('.$services->service_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Service"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(['status', 'actions','company_name'])
        ->make(true);
    }

    /**
     * getForDataTable
     *
     * @return void
     */
    public function getForDataTable($input)
    {
        $dataTableQuery = Services::leftJoin('companies', 'services.company_id', '=', 'companies.id')
        ->leftJoin('service_categorys', 'services.category_id', '=', 'service_categorys.id')
        ->select([
            'companies.person_name',
            'companies.company_name',
            'companies.id as company_id',
            'services.id as service_id',
            'services.service_name',
            'services.service_provider_name',
            'services.contact_number',
            'services.mobile_number',
            'services.email',
            'services.address',
            'services.status as services_status',
            'service_categorys.id as category_id',
            'service_categorys.category_name as category_name',
            'services.created_at',
        ]);

        
        if (isset($input['company_name']) && $input['company_name'] != '') {
            
            $dataTableQuery->where('company_id',$input['company_name']);
        }
        
        return $dataTableQuery;
    }
}
