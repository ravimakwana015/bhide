<?php

namespace App\Http\Controllers\Admin\Alluser;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Services;
use App\Models\Facilities;
use Carbon\Carbon;
use App\Models\Units;
use App\Models\AppUsers;
use App\Models\Parcels;
use Session;
use DB;
use App\Mail\SendLoginDetailsMail;
use App\Http\Controllers\Controller;



class AllUserController extends Controller
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
        return view('admin.allusers.index',compact('companys'));
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
            'email' => 'required|unique:app_users',
            'password' => 'required',
            'unit_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'member_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|unique:app_users',
        ]);
        $input = $request->all();
        $password = $input['password'];
        $input['password'] = bcrypt($input['password']);
        $input['date_of_birth'] = date("Y-m-d", strtotime($input['date_of_birth']));
        $input['company_id'] = $input['company_id'];
        $user = AppUsers::create([
            'unit_id'    => $input['unit_id'],
            'company_id' => $input['company_id'],
            'password'   => bcrypt($input['password']),
            'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
            'member_type' => $input['member_type'],
            'first_name' => $input['first_name'],
            'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
            'member_image' => $input['member_images'],
            'address' => $input['address'],
            'city' => $input['city'],
            'country' => $input['country'],
            'zip_code' => $input['zip_code'],
            'email' => $input['email'],
        ]);
        //Mail::to($input['email'])->send(new SendLoginDetailsMail($user, $password));
        return response()->json(['status' => 1, 'msg' => 'User Added Successfully!!']);
        // return redirect()->route('appuser.index')->with('success', 'Users Added Successfully!!');
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

    public function editallusers(Request $request,$id) {
        $data['user'] = AppUsers::find($id);
        $data['flats']= Units::get();
        
        $data['companys'] = Company::all();

        $editData = view('admin.allusers.edit', $data)->render();

        return json_encode(array('status'=>1,'data'=>$editData));
    }

    public function updateusers(Request $request)
    {

        $user = AppUsers::where('id', $request->id)->first();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'member_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|unique:app_users,phone_number,' . $user->id,
        ]);
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);

        if(isset($input['member_image']))
        {
            AppUsers::where('id', $user->id)->update([
                'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
                'member_type' => $input['member_type'],
                'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'last_name' => $input['last_name'],
                'phone_number' => $input['phone_number'],
                'member_image' => $input['member_images'],
                'address' => $input['address'],
                'city' => $input['city'],
                'country' => $input['country'],
                'zip_code' => $input['zip_code'],
            ]);
        }
        else
        {
            AppUsers::where('id', $user->id)->update([
                'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
                'member_type' => $input['member_type'],
                'first_name' => $input['first_name'],
                'middle_name' => $input['middle_name'],
                'last_name' => $input['last_name'],
                'phone_number' => $input['phone_number'],
                'member_image' => $user->member_image,
                'address' => $input['address'],
                'city' => $input['city'],
                'country' => $input['country'],
                'zip_code' => $input['zip_code'],
            ]);
        }

        return json_encode(array('status'=>1));
    }

    public function deleteusers(Request $request)
    {
        $service = AppUsers::find($request->id);
        $service->delete();
        Session::flash('error', "User Deleted Successfully !!");
        return redirect()->route('alluser.index');
    }

    public function uploadAllIcon(Request $request)
    {
        $input = $request -> all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = public_path('front/member_image/').$image_name;
        //$path = '/public/front/building_image/'.$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }
    public function sendLoginDetails($user_id)
    {
        $password = Str::random(10);
        $user = AppUsers::where('id', $user_id)->first();
        
        if (isset($user)) {
            $user->update([
                'password' => bcrypt($password),
            ]);
            Mail::to($user->email)->send(new SendLoginDetailsMail($user, $password));
            Session::flash('success', "Login details sent successfully.");
            return redirect()->route('alluser.index');
        } else {
            Session::flash('error', "User not available");
            return redirect()->route('alluser.index');
        }
    }
}
