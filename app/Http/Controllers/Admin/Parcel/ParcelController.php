<?php

namespace App\Http\Controllers\Admin\Parcel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Services;
use App\Models\Facilities;
use Carbon\Carbon;
use App\Models\Units;
use App\Models\Parcels;
use Session;
use DB;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Company::all();
        $companys = [];
        $companys[''] = 'Select Company Name';
        foreach ($units as $unit) {
            $companys[$unit->id] = $unit->company_name;
        }

        return view('admin.parcels.index',compact('companys'));
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
        $this->validate($request, [
            'company_id' => 'required',
            'unit_id' => 'required',
            'total_parcel' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = $request->company_id;
        Parcels::create($input);
        // Session::flash('success', "Parcel added Successfully !!");
        // return redirect()->route('parcel.index');

        return response()->json(['status' => 1, 'msg' => 'Parcel Added Successfully!!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUnits(Request $request)
    {
        $all = $request->all();
        
        $units = Units::select(
            DB::raw("CONCAT(block_number,' ',flat_number) AS name"),'id')
            ->where('company_id', $request->id)
            ->pluck('name', 'id');
        return json_encode($units);
    }

    public function editparcel(Request $request,$id) {
        $data['companys'] = Company::all();

        $data['parcels'] = Parcels::find($id);
        $data['units'] = Units::where('company_id',$data['parcels']->company_id)->get();
        
        $editData = view('admin.parcels.edit', $data)->render();
        return json_encode(array('status'=>1,'data'=>$editData));
    }


    public function updateparcel(Request $request) {

        $facilityID = $request->id;

        $this->validate($request, [
            'company_id' => 'required',
            'unit_id' => 'required',
            'total_parcel' => 'required',
            'status' => 'required',
        ]);

        Parcels::where('id', $facilityID)->update([
            'company_id' => $request->company_id, 
            'unit_id' => $request->unit_id, 
            'total_parcel' => $request->total_parcel,
            'name' => $request->name,
            'status' => $request->status
        ]);

        return json_encode(array('status'=>1));
    }

    public function deleteparcel(Request $request)
    {
        $service = Parcels::find($request->id);
        $service->delete();
        Session::flash('error', "Parcel Deleted Successfully !!");
        return redirect()->route('parcel.index');
    }

}
