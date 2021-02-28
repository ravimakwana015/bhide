<?php

namespace App\Http\Controllers\Admin\LoyaltyStores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyCategorys;
use Session;

class LoyaltyStoresController extends Controller
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

        $categorys = LoyaltyCategorys::all();
        $flats = [];
        $flats[''] = 'Select Category';
        foreach ($categorys as $unit) {
            $flats[$unit->id] = $unit->lcategory_name;
        }
        return view('admin.loyaltystores.index',compact('companys','flats'));
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
            'store_name' => 'required',
            'store_address' => 'required',
            'store_offers' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = $request->company_id;
        LoyaltyCard::create($input);
        return response()->json(['status' => 1, 'msg' => 'Loyalty Store Added Successfully!!']);
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
        $data['LoyaltyStores'] = LoyaltyCard::find($id);
        $data['serviceCategorys'] = LoyaltyCategorys::all();
        $editData = view('admin.loyaltystores.edit', $data)->render();
        return json_encode(array('status'=>1,'data'=>$editData));
    }


    public function updateLoyaltyStores(Request $request) {

        $facilityID = $request->id;

        $this->validate($request, [
            'store_name' => 'required',
            'store_address' => 'required',
            'category_id' => 'required',
            'store_offers' => 'required',
        ]);

        LoyaltyCard::where('id', $facilityID)->update([
            'company_id' => $request->company_id, 
            'store_name' => $request->store_name, 
            'category_id' => $request->category_id, 
            'store_address' => $request->store_address,
            'store_offers' => $request->store_offers
        ]);

        return json_encode(array('status'=>1));
    }

    public function deleteLoyaltyStores(Request $request)
    {
        $service = LoyaltyCard::find($request->id);
        $service->delete();
        Session::flash('error', "Loyalty Store Deleted Successfully !!");
        return redirect()->route('loyaltystores.index');
    }

}
