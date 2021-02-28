<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Services;
use App\Models\ServiceCategorys;
use Session;

class ServiceController extends Controller
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

        $categorys = ServiceCategorys::all();
        $flats = [];
        $flats[''] = 'Select Category';
        foreach ($categorys as $unit) {
            $flats[$unit->id] = $unit->category_name;
        }
        return view('admin.services.index',compact('companys','flats'));
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
            'service_name' => 'required',
            'service_provider_name' => 'required',
            'contact_number' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = $request->company_id;
        Services::create($input);
        return response()->json(['status' => 1, 'msg' => 'Service Added Successfully!!']);
        // Session::flash('success', "Service added Successfully !!");
        // return redirect()->route('service.index');
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

    public function editservice(Request $request , $id) {
        $data['companys'] = Company::all();
        $data['serviceCategorys'] = ServiceCategorys::all();
        $data['service'] = Services::find($id);
        $editData = view('admin.services.edit', $data)->render();
        return json_encode(array('status'=>1,'data'=>$editData));
    }

    public function updateservice(Request $request) {

        $serviceID = $request->id;

        $this->validate($request, [
            'service_name' => 'required',
            'service_provider_name' => 'required',
            'contact_number' => 'required',
            'status' => 'required',
        ]);

        Services::where('id', $serviceID)->update([
            'company_id' => $request->company_id, 
            'category_id' => $request->category_id, 
            'service_name' => $request->service_name, 
            'service_provider_name' => $request->service_provider_name,
            'contact_number' => $request->contact_number,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'status' => $request->status,
            'address' => $request->address
        ]);

        return json_encode(array('status'=>1));
    }

    public function deleteservice(Request $request)
    {
        $service = Services::find($request->id);
        $service->delete();
        Session::flash('error', "Service Deleted Successfully !!");
        return redirect()->route('service.index');
    }

}
