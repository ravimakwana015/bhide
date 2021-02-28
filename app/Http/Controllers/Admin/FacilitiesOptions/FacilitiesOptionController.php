<?php

namespace App\Http\Controllers\Admin\FacilitiesOptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilitiesOption;
use Session;

class FacilitiesOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.facilitiesoptions.index');
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
         $validatedData = $request->validate([
            'title' => 'required|unique:pages',
            'status' => 'required',
        ],[
            'title.required' => 'Please Enter Page Title',
            'title.unique' => 'Page Already exist',
            'status.required' => 'Please Select Status',
        ]);

        $input = $request->all();
        FacilitiesOption::create($input);
        
        return response()->json(['status' => 1, 'msg' => 'Options Added Successfully!!']);
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

    public function editfacilitiesoptions(Request $request,$id) {
        $data['facilitiesoptions'] = FacilitiesOption::find($id);

        $editData = view('admin.facilitiesoptions.edit', $data)->render();

        return json_encode(array('status'=>1,'data'=>$editData));
    }

    public function updatefacilitiesoptions(Request $request) {

        $facilityID = $request->id;

        $validatedData = $request->validate([
            'title' => 'required',
            'status' => 'required',
        ],[
            'title.required' => 'Please Enter Page Title',
            'status.required' => 'Please Select Status',
        ]);

        FacilitiesOption::where('id', $facilityID)->update([
            'title' => $request->title, 
            'status' => $request->status
        ]);

        return json_encode(array('status'=>1));
    }

    public function deletefacilitiesoptions(Request $request)
    {
        $service = FacilitiesOption::find($request->id);
        $service->delete();
        Session::flash('error', "Option Deleted Successfully !!");
        return redirect()->route('facilitiesoptions.index');
    }
}
