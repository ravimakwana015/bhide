<?php

namespace App\Http\Controllers\Admin\Concierge;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Gates;
use App\Models\Concierges;
use App\Http\Controllers\Controller;

class ConciergeDataTablesController extends Controller
{
    public function getData(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($concierges) {
            return Carbon::parse($concierges->created_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('updated_at', function ($concierges) {
            return Carbon::parse($concierges->updated_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('gate', function ($concierges) {
            return $concierges->gate_name;
        })
        ->editColumn('concierge_image', function ($concierges) {
            return "<img src='" . asset('public/front/concierges_image/') . "/" . $concierges->concierge_image . "' width='80' height='80' id='career_img'>";
        })
        ->editColumn('shift', function ($concierges) {
            $start = trim(explode(':',$concierges->shift_start)[0]).":".trim(explode(':',$concierges->shift_start)[1]);
            $end = trim(explode(':',$concierges->shift_end)[0]).":".trim(explode(':',$concierges->shift_end)[1]);
            $timeString = $start. " TO ". $end;
            return $timeString;
        })
        ->addColumn('actions', function ($concierges) {
            $actions = '<a title="Edit Visitor" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('concierge.edit', $concierges->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("concierge.destroy", $concierges) . '" id="delete_' . $concierges->id . '" onclick="deletePopup(' . $concierges->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            return $actions;
        })
        ->rawColumns(['actions', 'concierge_image'])
        ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Concierges::leftjoin('gates as g', 'g.id', '=', 'concierges.gate_id')
        ->select([
            'concierges.*',
            DB::raw('CONCAT(concierges.last_name," ",concierges.first_name) AS name'),
            'g.id as cid',
            'g.name as gate_name',
        ])->orderBy('id', 'desc');
       
        return  $dataTableQuery;
    }
}
