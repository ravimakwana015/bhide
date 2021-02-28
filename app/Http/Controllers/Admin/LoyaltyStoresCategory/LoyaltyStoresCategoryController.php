<?php

namespace App\Http\Controllers\Admin\LoyaltyStoresCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyCategorys;
use Session;

class LoyaltyStoresCategoryController extends Controller
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
        return view('admin.loyaltystorescategory.index',compact('companys'));
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
            'lcategory_name' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = $request->company_id;
        LoyaltyCategorys::create($input);
        return response()->json(['status' => 1, 'msg' => 'Loyalty Store Category Added Successfully!!']);
        // Session::flash('success', "Loyalty Store added Successfully !!");
        // return redirect()->route('loyaltystores.index');
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

    public function editLoyaltyStores(Request $request,$id) {
        $data['companys'] = Company::all();
        $data['LoyaltyStores'] = LoyaltyCategorys::find($id);
        
        $editData = view('admin.loyaltystorescategory.edit', $data)->render();
        return json_encode(array('status'=>1,'data'=>$editData));
    }


    public function updateLoyaltyStores(Request $request) {

        $facilityID = $request->id;

        $this->validate($request, [
            'company_id' => 'required',
            'lcategory_name' => 'required',
            'status' => 'required',
        ]);

        LoyaltyCategorys::where('id', $facilityID)->update([
            'company_id' => $request->company_id, 
            'lcategory_name' => $request->lcategory_name, 
            'status' => $request->status
        ]);

        return json_encode(array('status'=>1));
    }

    public function deleteLoyaltyStores(Request $request)
    {
        $service = LoyaltyCategorys::find($request->id);
        $service->delete();
        Session::flash('error', "Loyalty Store Category Deleted Successfully !!");
        return redirect()->route('loyaltystorescategory.index');
    }

}
