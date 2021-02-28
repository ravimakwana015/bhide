<?php

namespace App\Http\Controllers\Visitors;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Visitors;
use App\Models\Units;
use App\Models\ReasonForVisit;
use App\Models\Gates;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Controller;

class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('visitors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gates = Gates::pluck('name', 'id')->toArray();
        $reasons = ReasonForVisit::pluck('reason', 'id')->toArray();
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Apartment';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('visitors.create', compact('gates', 'reasons', 'flats'));
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
            'gate_id' => 'required',
            'reason_id' => 'required',
            'unit_id' => 'required',
            'check_in_date' => 'required',
            'check_in_time' => 'required',
            'visitor_name' => 'required',
            'id_name' => 'required',
            'id_number' => 'required',
        ]);
        $input = $request->all();
        $input['check_in_date'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['check_in_date'])));
        $input['company_id'] = Auth::user()->company->id;
        $input['check_in_time'] =  str_replace(' ', '', $input['check_in_time']);
        Visitors::create($input);
        $deviceTokens = getDeviceTokens($input['unit_id']);
        if (count($deviceTokens)) {
            try {
                $title = 'Visitors Arrived';
                $body = 'Visitors arriving at your unit';
                $type = 'visitor';
                $res = $notification->senNotification($deviceTokens, $body, $title, $type);
                if ($res['status'] == 1) {
                    return redirect()->route('visitors.index')->with('success', 'Visitors Added Successfully!!');
                } else {
                    return redirect()->route('visitors.index')->with('success', 'Visitors Added Successfully. Firebase Server Key No Available. Please Contact your Admin!!');
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return redirect()->route('visitors.index')->with('success', 'Visitors Added Successfully!!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitors  $visitors
     * @return \Illuminate\Http\Response
     */
    public function show(Visitors $visitors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitors  $visitors
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = Visitors::find($id);
        $gates = Gates::where('company_id', Auth::user()->company->id)->pluck('name', 'id')->toArray();
        $reasons = ReasonForVisit::where('company_id', Auth::user()->company->id)->pluck('reason', 'id')->toArray();
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Unit';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('visitors.edit', compact('gates', 'reasons', 'flats', 'visitor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitors  $visitors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visitor = Visitors::find($id);
        $this->validate($request, [
            'gate_id' => 'required',
            'reason_id' => 'required',
            'unit_id' => 'required',
            'check_in_date' => 'required',
            'check_in_time' => 'required',
            'visitor_name' => 'required',
            'id_name' => 'required',
            'id_number' => 'required',
        ]);
        $input = $request->all();
        $input['check_in_date'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['check_in_date'])));
        $input['check_in_time'] =  str_replace(' ', '', $input['check_in_time']);
        $visitor->update($input);
        return redirect()->route('visitors.index')->with('success', 'Visitor Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitors  $visitors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Visitors::find($id)->delete();
        return redirect()->route('visitors.index')->with('success', 'Visitor Delete Successfully!!');
    }

    public function getVisitors(Request $request)
    {
        return DataTables::make($this->getForDataTable($request->all()))
            ->editColumn('created_at', function ($visitors) {
                return Carbon::parse($visitors->created_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('updated_at', function ($visitors) {
                return Carbon::parse($visitors->updated_at)->format('d/m/Y h:i:s A');
            })
            ->editColumn('check_in_date', function ($visitors) {
                return Carbon::parse($visitors->check_in_date)->format('d/m/Y') . ' ' . $visitors->check_in_time;
            })
            ->editColumn('check_out_date', function ($visitors) {
                if ($visitors->check_out_date != '') {
                    return Carbon::parse($visitors->check_out_date)->format('d/m/Y') . ' ' . $visitors->check_out_time;
                }
            })
            ->editColumn('gate', function ($visitors) {
                return $visitors->gate_name;
            })
            ->addColumn('actions', function ($visitors) {
                $actions = '<a title="Edit Visitor" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('visitors.edit', $visitors->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
                </a> <button onclick="visitorCheckOutModal(' . $visitors->id . ')" class="btn btn" id="visitorCheckBtn" data-url="' . route("visitor.checkout") . '">Check out</button> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("visitors.destroy", $visitors) . '" id="delete_' . $visitors->id . '" onclick="deletePopup(' . $visitors->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Visitors::where('visitors.company_id', Auth::user()->company->id)->leftjoin('gates as g', 'g.id', '=', 'visitors.gate_id')
            ->leftjoin('units as u', 'visitors.unit_id', '=', 'u.id')
            ->leftjoin('reason_for_visits as rv', 'visitors.reason_id', '=', 'rv.id')
            ->select([
                'visitors.*',
                DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit'),
                'g.id as cid',
                'g.name as gate_name',
                'rv.reason',
            ])->orderBy('id', 'desc');
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

    public function getGates()
    {
        $gates = Gates::where('company_id', Auth::user()->company->id)->get();
        return response()->json(['gates' => $gates]);
    }
    public function addGate(Request $request)
    {
        $input =  $request->all();
        $input['company_id'] = Auth::user()->company->id;
        $gate = Gates::create($input);
        return response()->json(['status' => 1, 'gate' => $gate]);
    }
    public function getReasons()
    {
        $reasons = ReasonForVisit::where('company_id', Auth::user()->company->id)->get();
        return response()->json(['reasons' => $reasons]);
    }
    public function addReason(Request $request)
    {
        $input =  $request->all();
        $input['company_id'] = Auth::user()->company->id;
        $reason = ReasonForVisit::create($input);
        return response()->json(['status' => 1, 'reason' => $reason]);
    }
    public function visitorCheckout(Request $request)
    {
        $this->validate($request, [
            'check_out_date' => 'required',
            'check_out_time' => 'required',
        ]);
        $input =  $request->all();
        $visitor = Visitors::find($input['id']);
        $input['check_out_date'] = date("Y-m-d", strtotime(str_replace('/', '-', $input['check_out_date'])));
        $input['check_out_time'] =  str_replace(' ', '', $input['check_out_time']);
        $visitor->update([
            'check_out_date' => $input['check_out_date'],
            'check_out_time' => $input['check_out_time']
        ]);
        return response()->json(['status' => 1, 'msg' => 'Check out updated successfully']);
    }
}
