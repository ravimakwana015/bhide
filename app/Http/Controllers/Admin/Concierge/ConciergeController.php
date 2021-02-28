<?php

namespace App\Http\Controllers\Admin\Concierge;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Gates;
use App\Models\Company;
use App\Models\Concierges;

class ConciergeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.members.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Company::all();
        $companys = [];
        $companys[''] = 'Select Company Name';
        foreach ($units as $unit) {
            $companys[$unit->id] = $unit->company_name;
        }
        $gates = Gates::pluck('name', 'id')->toArray();
        
        return view('admin.members.create', compact('gates','companys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token', '_method');
       
        $this->validate($request, [
            'email' => 'required|unique:app_users',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|unique:concierges',
            'concierge_image' => 'required|image',
        ]);
        $logo = $input['concierge_image'];
        $image_name = time() . $logo->getClientOriginalName();
        //Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
        
        Concierges::create([
            'gate_id' => $input['gate_id'],
            'company_id' => $input['company_id'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'shift_start' => str_replace(' ', '', $input['shift_start']),
            'shift_end' => str_replace(' ', '', $input['shift_end']),
            'concierge_image' => $input['concierge_images'],
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'country' => $input['country'],
            'zip_code' => $input['zip_code'],
        ]);
        return redirect()->route('concierge.index')->with('success', 'Concierge Added Successfully!!');
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
        $units = Company::all();
        $companys = [];
        $companys[''] = 'Select Company Name';
        foreach ($units as $unit) {
            $companys[$unit->id] = $unit->company_name;
        }
        $concierge = Concierges::find($id);
        $gates = Gates::pluck('name', 'id')->toArray();
        return view('admin.members.edit', compact('gates', 'concierge', 'companys'));
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
        $input = $request->except('_token', '_method');
        $concierge = Concierges::find($id);
        $this->validate($request, [
            'email' => 'required|email|unique:concierges,email,' . $concierge->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|unique:concierges,phone_number,' . $concierge->id,
            'concierge_image' => 'sometimes|required|image',
        ]);
        if (isset($input['concierge_image'])) {
            $logo = $input['concierge_image'];
            $image_name = time() . $logo->getClientOriginalName();
            //Storage::put($this->site_logo_path . $image_name, file_get_contents($logo->getRealPath()));
            $input['concierge_image'] = $image_name;
        }
        $input['shift_start'] =  str_replace(' ', '', $input['shift_start']);
        $input['shift_end'] =  str_replace(' ', '', $input['shift_end']);

        if(isset($input['concierge_images']))
        {
            $concierge->update([
                'concierge_image' => $input['concierge_images'],
            ]);
        }
        else
        {
            $concierge->update([
                'concierge_image' => $concierge->concierge_image,
            ]);
        }

        $concierge->update([
            'gate_id' => $input['gate_id'],
            'company_id' => $input['company_id'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'gender' => $input['gender'],
            'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'shift_start' => str_replace(' ', '', $input['shift_start']),
            'shift_end' => str_replace(' ', '', $input['shift_end']),
            'address' => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'country' => $input['country'],
            'zip_code' => $input['zip_code'],
        ]);

        // $concierge->update($input);
        return redirect()->route('concierge.index')->with('success', 'Concierge updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Concierges::find($id)->delete();
        return redirect()->route('concierge.index')->with('success', 'Concierge Deleted Successfully!!');
    }

    public function getGates()
    {
        $gates = Gates::get();
        return response()->json(['gates' => $gates]);
    }
    public function addGate(Request $request)
    {
        $this->validate($request, [
            'company_id' => 'required',
            'name' => 'required',
        ]);
        $input =  $request->all();
        
        $input['company_id'] = $request->company_id;
        $gate = Gates::create($input);
        return response()->json(['status' => 1, 'gate' => $gate]);
    }

    public function uploadConciergesIcon(Request $request)
    {
        $input = $request -> all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = public_path('front/concierges_image/').$image_name;
        //$path = '/public/front/building_image/'.$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }
}
