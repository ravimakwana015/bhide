<?php

namespace App\Http\Controllers\Admin\FacilitiesOptions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pages;
use App\Models\FacilitiesOption;
use Carbon\Carbon;

class FacilitiesOptionDataTablesController extends Controller
{
    public function __invoke()
    {       
        return Datatables::make(FacilitiesOption::query())
        ->addColumn('created_at', function ($page) {
            return Carbon::parse($page->created_at)->format('d/m/Y H:i:s');
        }) ->addColumn('updated_at', function ($page) {
            return Carbon::parse($page->updated_at)->format('d/m/Y H:i:s');
        })
        ->addColumn('status', function ($page) {
            if($page->status==1){
                return "<label class='btn btn-success btn-xs'>Active</label>";
            }
            else{
                return "<label class='btn btn-warning btn-xs'>Inactive</label>";
            }
        })->addColumn('actions', function($page)
        {
            return '<button type="button" class="btn btn-outline-info" onclick="getData('.$page->id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit Page"><i class="fas fa-user-edit"></i></button> <button type="button" class="btn btn-outline-danger" onclick="getDelete('.$page->id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete Page"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(['status','actions'])
        ->make(true);
    }
}
