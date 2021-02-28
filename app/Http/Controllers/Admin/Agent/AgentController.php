<?php

namespace App\Http\Controllers\Admin\Facilitie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Services;
use App\Models\Facilities;
use Session;

class AgentController extends Controller
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
        return view('admin.agent.index',compact('companys'));
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
            'facility_name' => 'required',
            'contact' => 'required',
            'availability' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        $input['company_id'] = $request->company_id;
        Facilities::create($input);
        Session::flash('success', "Facilitie added Successfully !!");
        return redirect()->route('facilitie.index');
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

    public function editfacilitie(Request $request,$id) {
        $data['companys'] = Company::all();
        $data['facilitie'] = Facilities::find($id);
        
        $editData = view('admin.facilities.edit', $data)->render();
        return json_encode(array('status'=>1,'data'=>$editData));
    }


    public function updatefacilitie(Request $request) {

        $facilityID = $request->id;

        $this->validate($request, [
            'facility_name' => 'required',
            'contact' => 'required',
            'availability' => 'required',
            'status' => 'required',
        ]);

        Facilities::where('id', $facilityID)->update([
            'company_id' => $request->company_id, 
            'facility_name' => $request->facility_name, 
            'contact' => $request->contact,
            'availability' => $request->availability,
            'status' => $request->status
        ]);

        return json_encode(array('status'=>1));
    }

    public function deletefacilitie(Request $request)
    {
        $service = Facilities::find($request->id);
        $service->delete();
        Session::flash('error', "Facilitie Deleted Successfully !!");
        return redirect()->route('facilitie.index');
    }
}
