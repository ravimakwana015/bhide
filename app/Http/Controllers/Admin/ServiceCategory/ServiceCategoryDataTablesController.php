<?php

namespace App\Http\Controllers\Admin\ServiceCategory;

use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\ServiceCategorys;
use App\Models\Company;
use App\Http\Controllers\Controller;

class ServiceCategoryDataTablesController extends Controller
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
            if ($services->services_status == 0) {
                return '<label class="btn btn-success btn-xs">Open</label>';
            } else  if ($services->services_status == 1) {
                return '<label class="btn btn-danger btn-xs">Close</label>';
            }
        })->addColumn('actions', function ($services) { 
            return '<button type="button" class="btn btn-outline-info" onclick="getData('.$services->service_categorys_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Service Category"><i class="fas fa-user-edit"></i></button>   
                <button type="button" class="btn btn-outline-danger" onclick="getDelete('.$services->service_categorys_id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Service Category"><i class="fas fa-trash"></i></button>';
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
        $dataTableQuery = ServiceCategorys::leftJoin('companies', 'service_categorys.company_id', '=', 'companies.id')
        ->select([
            'companies.person_name',
            'companies.company_name',
            'companies.id as company_id',
            'service_categorys.id as service_categorys_id',
            'service_categorys.category_name',
            'service_categorys.status as services_status',
            'service_categorys.created_at',
        ])->get();

        if (isset($input['company_name']) && $input['company_name'] != '') {
            
            $dataTableQuery->where('company_id',$input['company_name']);
        }
        
        return $dataTableQuery;
    }
}
