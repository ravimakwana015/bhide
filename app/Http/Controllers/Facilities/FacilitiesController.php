<?php

namespace App\Http\Controllers\Facilities;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Facilities;
use App\Models\AppUsers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facilities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotificationController $notification)
    {
        $this->validate($request, [
            'facility_name' => 'required',
            'contact' => 'required',
            'availability' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = Auth::user()->company->id;
        Facilities::create($input);

        $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
        if (count($deviceTokens) > 0) {
            try {
                $title = 'New Facility Available';
                $body = 'New Facility Available in Apartment';
                $type = 'facility';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return response()->json(['status' => 1, 'msg' => 'Facility Added Successfully!!']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Facility Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(['status' => 1, 'msg' => 'Facility Added Successfully!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function show(Facilities $facilities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facility = Facilities::find($id);
        $editFacility = view('facilities.edit_modal', compact('facility'))->render();
        return response()->json(['status' => 1, 'html' => $editFacility]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'facility_name' => 'required',
            'contact' => 'required',
            'availability' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);
        Facilities::where('id', $id)->update($input);
        return redirect()->route('facilities.index')->with('success', 'Facility Update Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Facilities::where('id', $id)->delete();
        return redirect()->route('facilities.index')->with('success', 'Facility Deleted Successfully!!');
    }

    public function getFacilities(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($facilities) {
                return Carbon::parse($facilities->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($facilities) {
                return Carbon::parse($facilities->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('status', function ($facilities) {
                if ($facilities->status ==1) {
                    return '<label class="btn btn-warning btn-xs">Active</label>';
                } else  if ($facilities->status == 0) {
                    return '<label class="btn btn-success btn-xs">In Active</label>';
                }
            })
            ->addColumn('actions', function ($facilities) {
                $actions = '<a title="Edit Facilitie" class="btn btn-sm btn-outline-primary btn-icon" href="javascript:;" data-url="' . route('facilities.edit', $facilities->id) . '" id="edit_' . $facilities->id . '" onclick="editPopup(' . $facilities->id . ')" > <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
                </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("facilities.destroy", $facilities) . '" id="delete_' . $facilities->id . '" onclick="deletePopup(' . $facilities->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['status','actions'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Facilities::where('company_id',Auth::user()->company->id)->orderBy('id', 'desc');
        // if (isset($input['month']) && $input['month'] != '') {
        //     $dataTableQuery->whereMonth('created_at', '=', $input['month']);
        // }
        // if (isset($input['year']) && $input['year'] != '') {
        //     $dataTableQuery->whereYear('created_at', '=', $input['year']);
        // }
        // if (isset($input['from_date']) && isset($input['to_date']) && $input['from_date'] != '' && $input['to_date'] != '') {
        //     $dataTableQuery->whereBetween('created_at', array($input['from_date'], $input['to_date']));
        // }
        // if (isset($input['status']) && $input['status'] != '') {

        //     $dataTableQuery->where(function ($fq) use ($input) {
        //         if ($input['status'] == '7') {
        //             $fq->where('status', '=', '3')->orWhere('status', '=', '7');
        //         } else {
        //             $fq->where('status', '=', $input['status']);
        //         }
        //     });
        // }
        // if (isset($input['payment_status']) && $input['payment_status'] != '') {
        //     $dataTableQuery->where('payment_status', '=', $input['payment_status']);
        // }
        return  $dataTableQuery;
    }
}
