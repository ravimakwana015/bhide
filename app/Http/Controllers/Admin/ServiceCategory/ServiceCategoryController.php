<?php

namespace App\Http\Controllers\Admin\ServiceCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ServiceCategorys;
use Session;

class ServiceCategoryController extends Controller
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
        return view('admin.servicescategory.index',compact('companys'));
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
            'category_name' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = $request->company_id;
        ServiceCategorys::create($input);
        return response()->json(['status' => 1, 'msg' => 'Service Category Added Successfully!!']);
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
        $data['service'] = ServiceCategorys::find($id);
        
        $editData = view('admin.servicescategory.edit', $data)->render();
        return json_encode(array('status'=>1,'data'=>$editData));
    }

    public function updateservice(Request $request) {

        $serviceID = $request->id;

        $this->validate($request, [
            'company_id' => 'required',
            'category_name' => 'required',
            'status' => 'required',
        ]);

        ServiceCategorys::where('id', $serviceID)->update([
            'company_id' => $request->company_id, 
            'category_name' => $request->category_name, 
            'status' => $request->status
        ]);

        return json_encode(array('status'=>1));
    }

    public function deleteservice(Request $request)
    {
        $service = ServiceCategorys::find($request->id);
        $service->delete();
        Session::flash('error', "Service Category Deleted Successfully !!");
        return redirect()->route('servicecategory.index');
    }

}
