<?php

namespace App\Http\Controllers\Services;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Services;
use App\Models\ServiceCategorys;
use App\Models\AppUsers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = ServiceCategorys::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Category';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->category_name;
        }
        return view('services.index', compact('flats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
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
            'service_name' => 'required',
            'service_provider_name' => 'required',
            'contact_number' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = Auth::user()->company->id;
        Services::create($input);

        $deviceTokens = AppUsers::where('deviceToken', '!=', '')->pluck('deviceToken');
        if (count($deviceTokens) > 0) {
            try {
                $title = 'New Service Available';
                $body = 'New Service Available in Apartment';
                $type = 'service';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return response()->json(['status' => 1, 'msg' => 'Service Added Successfully!!']);
                } else {
                    return response()->json(['status' => 1, 'msg' => 'Service Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(['status' => 1, 'msg' => 'Service Added Successfully!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $units = ServiceCategorys::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Category';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->category_name;
        }
        $service = Services::find($id);
        $editService = view('services.edit_modal', compact('service','flats'))->render();
        return response()->json(['status' => 1, 'html' => $editService]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'service_name' => 'required',
            'service_provider_name' => 'required',
            'contact_number' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);
        Services::where('id', $id)->update($input);
        return redirect()->route('services.index')->with('success', 'Service Update Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $services = Services::where('id', $id)->delete();
        return redirect()->route('services.index')->with('success', 'Service Deleted Successfully!!');
    }

    public function getServices(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($services) {
                return Carbon::parse($services->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($services) {
                return Carbon::parse($services->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('status', function ($services) {
                if ($services->status == 1) {
                    return '<label class="btn btn-success btn-xs">Open</label>';
                } else  if ($services->status == 0) {
                    return '<label class="btn btn-warning btn-xs">Close</label>';
                }
            })
            ->addColumn('actions', function ($services) {
                $actions = '<a title="Edit Service" class="btn btn-sm btn-outline-primary btn-icon" href="javascript:;" data-url="' . route('services.edit', $services->id) . '" id="edit_' . $services->id . '" onclick="editPopup(' . $services->id . ')"> <span class="ul-btn__icon"><i class="fas fa-edit"></i></span>
                </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("services.destroy", $services) . '" id="delete_' . $services->id . '" onclick="deletePopup(' . $services->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['actions', 'status'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Services::where('company_id', Auth::user()->company->id)->orderBy('id', 'desc');
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
