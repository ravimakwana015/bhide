<?php

namespace App\Http\Controllers\Admin\Features;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Features;

class FeaturesDatatablesController extends Controller
{
    public function __invoke()
    {       
        return Datatables::make(Features::query())
        ->addColumn('created_at', function ($features) {
            return Carbon::parse($features->created_at)->format('d/m/Y H:i:s');
        })->addColumn('updated_at', function ($features) {
            return Carbon::parse($features->updated_at)->format('d/m/Y H:i:s');
        })->addColumn('content_edit', function ($features) {
            return $features->content;
        })
        ->addColumn('features_image', function ($features) {
            return "<img src='" . asset('public/front/features_image/') . "/" . $features->feature_image . "' width='80' height='80' id='career_img'>";
        })->addColumn('actions', function($features)
        {
            // <button type="button" class="btn btn-outline-info" onclick="getData('.$features->id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Edit features"><i class="fas fa-user-edit"></i></button>
            return '<a class="btn btn-outline-info" title="Edit features" href="'.route('features.edit',$features->id).'"><i class="fas fa-user-edit"></i></a> <button type="button" class="btn btn-outline-danger" onclick="getDelete('.$features->id.')" data-toggle="tooltip" data-trigger="hover" data-placement="top" title="Delete features"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(['status','actions','features_image','content_edit'])
        ->make(true);
    }
}
