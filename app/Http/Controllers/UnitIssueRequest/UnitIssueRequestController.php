<?php

namespace App\Http\Controllers\UnitIssueRequest;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\UnitIssueRequest;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class UnitIssueRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('issues.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function show(UnitIssueRequest $unitIssueRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $issues = UnitIssueRequest::find($id);
        return view('issues.edit', compact('issues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, NotificationController $notification)
    {
        $issues = UnitIssueRequest::find($id);
        $input = $request->all();
        $issues->update($input);

        $deviceTokens = getDeviceTokens($issues->unit_id);
        if (count($deviceTokens) > 0 && $input['status'] != 0) {
            try {
                $title = 'Issue Update';
                if ($input['status'] == 1) {
                    $status = 'is resolve';
                }elseif($input['status'] == 2) {
                    $status = 'is in Review';
                }
                $body = 'Your Issue '.$status;
                $type = 'issue';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return redirect()->route('issues.index')->with('success', 'Issue Updated Successfully!!');
                } else {
                    return redirect()->route('issues.index')->with('success', 'Issue Updated Successfully. Firebase Server Key No Available. Please Contact your Admin!!');
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return redirect()->route('issues.index')->with('success', 'Issue Updated Successfully!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitIssueRequest  $unitIssueRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UnitIssueRequest::find($id)->delete();
        return redirect()->route('issues.index')->with('success', 'Issue Deleted Successfully!!');
    }

    public function getIssues(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($issues) {
                return Carbon::parse($issues->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($issues) {
                return Carbon::parse($issues->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('status', function ($services) {
                if ($services->status == 1) {
                    return '<label class="btn btn-warning btn-xs">Close</label>';
                } else  if ($services->status == 0) {
                    return '<label class="btn btn-success btn-xs">Pending</label>';
                } else  if ($services->status == 2) {
                    return '<label class="btn btn-info btn-xs">In Review</label>';
                }
            })
            ->addColumn('actions', function ($issues) {
                $actions = '<a title="Edit Issue" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('issues.edit', $issues->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
                </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("issues.destroy", $issues) . '" id="delete_' . $issues->id . '" onclick="deletePopup(' . $issues->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function getForDataTable($input)
    {
        $dataTableQuery = UnitIssueRequest::where('unit_issue_requests.company_id', Auth::user()->company->id)
            ->leftjoin('units as u', 'unit_issue_requests.unit_id', '=', 'u.id')
            ->leftjoin('app_users as au', 'unit_issue_requests.user_id', '=', 'au.id')
            ->select([
                'unit_issue_requests.*',
                DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
                DB::raw('CONCAT(au.last_name," ",au.first_name) AS name'),
            ])
            ->orderBy('id', 'desc');
        return  $dataTableQuery;
    }
}
