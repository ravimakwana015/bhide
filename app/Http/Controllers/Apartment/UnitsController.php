<?php

namespace App\Http\Controllers\Apartment;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Units;
use App\Http\Controllers\Controller;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('units.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'block_number' => 'required',
            'flat_number' => 'required',
        ]);
        $input['company_id'] = Auth::user()->company->id;

        $allCompanyCountUnits = Units::where('company_id',Auth::user()->company->id)->count();

        if($allCompanyCountUnits >= '132')
        {
            return redirect()->back() ->withInput($request->input())->with('error', 'Maximum 132 Units Required');
        }
        else
        {
            $already = Units::where('block_number', $input['block_number'])
            ->where('company_id', $input['company_id'])
            ->where('flat_number', $input['flat_number'])
            ->first();
        }
        
        if (isset($already)) {
            return redirect()->back() ->withInput($request->input())->with('error', 'Unit Already Exist!!');
        }
        Units::create($input);
        return redirect()->route('units.index')->with('success', 'Unit Added Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function show(Units $units)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unit = Units::find($id);
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $unit = Units::where('id', $id)->first();
        $this->validate($request, [
            'block_number' => 'required',
            'flat_number' => 'required',
        ]);
        $input = $request->all();
        $already = Units::whereNotIn('id', [$id])->where('block_number', $input['block_number'])->where('flat_number', $input['flat_number'])->first();
        if (isset($already)) {
            return redirect()->back() ->withInput($request->input())->with('error', 'Unit Already Exist!!');
        }
        unset($input['_token']);
        unset($input['_method']);
        $unit->update($input);
        return redirect()->route('units.index')->with('success', 'Unit updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units  $units
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Units::where('id', $id)->delete();
        return redirect()->route('units.index')->with('success', 'Units Deleted Successfully!!');
    }

    public function getUnits(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($unit) {
            return Carbon::parse($unit->created_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('updated_at', function ($unit) {
            return Carbon::parse($unit->updated_at)->format('d/m/Y h:i:s A');
        })
        ->addColumn('actions', function ($unit) {
            $actions = '<a title="Edit User" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('units.edit', $unit->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("units.destroy", $unit) . '" id="delete_' . $unit->id . '" onclick="deletePopup(' . $unit->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            return $actions;
        })
        ->rawColumns(['status', 'actions'])
        ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = Units::where('units.company_id',Auth::user()->company->id)->leftjoin('companies as c', 'c.id', '=', 'units.company_id')
        ->select([
            'units.*',
            'c.id as cid',
            'c.company_name',
        ])
        ->orderBy('units.id', 'desc');
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
