<?php

namespace App\Http\Controllers\Apartment;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\Units;
use App\Models\AppUsers;
use App\Mail\SendLoginDetailsMail;
use App\Http\Controllers\Controller;

class ApartmentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Apartment';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('apartment.index', compact('flats'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Unit';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('apartment.create', compact('flats'));
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
            'phone_number' => 'required',
        ]);
        $input = $request->all();
        $password = $input['password'];
        // $input['password'] = bcrypt($input['password']);
        $input['date_of_birth'] = date("Y-m-d", strtotime($input['date_of_birth']));
        $input['company_id'] = Auth::user()->company->id;
        $user = AppUsers::create([
            'unit_id'    => $input['unit_id'],
            'company_id' => $input['company_id'],
            'password'   => bcrypt($input['password']),
            'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
            'member_type' => $input['member_type'],
            'first_name' => $input['first_name'],
            // 'middle_name' => $input['middle_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
            'member_image' => $input['member_images'],
            'address' => $input['address'],
            'city' => $input['city'],
            'country' => $input['country'],
            'zip_code' => $input['zip_code'],
            'email' => $input['email'],
        ]);
        Mail::to($input['email'])->send(new SendLoginDetailsMail($user, $password));
        return redirect()->route('apartment.index')->with('success', 'Member Added Successfully!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppUsers  $appUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = AppUsers::find($id);
        $units = Units::where('company_id', Auth::user()->company->id)->get();
        $flats = [];
        $flats[''] = 'Select Unit';
        foreach ($units as $unit) {
            $flats[$unit->id] = $unit->block_number . '-' . $unit->flat_number;
        }
        return view('apartment.edit', compact('user', 'units','flats'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppUsers  $appUser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = AppUsers::find($id);
        $members = AppUsers::where('unit_id', $user->unit_id)->get(['first_name', 'last_name', 'middle_name', 'member_type']);
        return view('apartment.show', compact('user', 'members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppUsers  $appUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = AppUsers::where('id', $id)->first();
        $this->validate($request, [
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
            'phone_number' => 'required',
        ]);
        $input = $request->all();
        unset($input['_token']);
        unset($input['_method']);

        if(isset($input['member_image']))
        {
            AppUsers::where('id', $user->id)->update([
                'company_id' => Auth::user()->company->id,
                'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
                'member_type' => $input['member_type'],
                'first_name' => $input['first_name'],
                // 'middle_name' => $input['middle_name'],
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
                'company_id' => Auth::user()->company->id,
                'date_of_birth' => date("Y-m-d", strtotime($input['date_of_birth'])),
                'member_type' => $input['member_type'],
                'first_name' => $input['first_name'],
                // 'middle_name' => $input['middle_name'],
                'last_name' => $input['last_name'],
                'phone_number' => $input['phone_number'],
                'member_image' => $user->member_image,
                'address' => $input['address'],
                'city' => $input['city'],
                'country' => $input['country'],
                'zip_code' => $input['zip_code'],
            ]);
        }

        

        return redirect()->route('apartment.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AppUsers::where('id', $id)->delete();
        return redirect()->route('apartment.index')->with('success', 'Service Deleted Successfully!!');
    }

    /**
     * Send Login Details to User
     *
     * @param [type] $user_id
     * @return void
     */
    public function sendLoginDetails($user_id)
    {
        $password = Str::random(10);
        $user = AppUsers::where('id', $user_id)->first();
        if (isset($user)) {
            $user->update([
                'password' => bcrypt($password),
            ]);
            Mail::to($user->email)->send(new SendLoginDetailsMail($user, $password));
            Session::flash('success', "Login details sent successfully. ");
            return redirect()->route('apartment.index');
        } else {
            Session::flash('error', "User not available");
            return redirect()->route('apartment.index');
        }
    }

    public function getUsers(Request $request)
    {
        return Datatables::make($this->getForDataTable($request->all()))
        ->editColumn('created_at', function ($appUser) {
            return Carbon::parse($appUser->created_at)->format('d/m/Y h:i:s A');
        })
        ->editColumn('updated_at', function ($appUser) {
            return Carbon::parse($appUser->updated_at)->format('d/m/Y h:i:s A');
        })->filterColumn('name', function ($dataTableQuery, $keyword) {
            $keywords = trim($keyword);
            $dataTableQuery->whereRaw("CONCAT(app_users.last_name, app_users.first_name) like ?", ["%{$keywords}%"]);
        })
        ->addColumn('actions', function ($appUser) {
            $actions = '<a title="View User" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('apartment.show', $appUser->id) . '"> <span class="ul-btn__icon"><i class="fas fa-eye"></i></span>
            </a> <a title="Edit User" class="btn btn-sm btn-outline-primary btn-icon" href="' . route('apartment.edit', $appUser->id) . '"> <span class="ul-btn__icon"><i class="fas fa-user-edit"></i></span>
            </a> <a class="btn btn-danger" href="' . route("send_login_details", $appUser->id) . '"  title="Send Login Details"><span class="ul-btn__icon"><i class="fas fa-paper-plane"></i></span></a> <a href="javascript:;" class="btn btn-danger addAttr" data-url="' . route("apartment.destroy", $appUser) . '" id="delete_' . $appUser->id . '" onclick="deletePopup(' . $appUser->id . ')"><span class="ul-btn__icon"><i class="fas fa-trash"></i></span></a>';
            return $actions;
        })
        ->rawColumns(['status', 'actions'])
        ->make(true);
    }

    public function getForDataTable($input)
    {

        $dataTableQuery = AppUsers::where('app_users.company_id',Auth::user()->company->id)->where('user_type','resident')->leftjoin('companies as c', 'c.id', '=', 'app_users.company_id')
        ->leftjoin('units as u', 'app_users.unit_id', '=', 'u.id')
        ->select([
            'app_users.*',
            DB::raw('CONCAT(app_users.first_name," ",app_users.last_name) AS name'),
            DB::raw('CONCAT(u.block_number,"-",u.flat_number) AS unit_name'),
            'c.id as cid',
            'c.company_name',
        ])
        ->orderBy('id', 'desc');
        if (isset($input['unit']) && $input['unit'] != '') {
            $dataTableQuery->where('unit_id',$input['unit']);
        }

        return  $dataTableQuery;
    }

    public function uploadApartmentIcon(Request $request)
    {
        $input = $request->all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
       // $path = asset('storage/app/img/loyaltyCard/').'/'.$image_name;
        $path = public_path('front/member_image/').$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }
}
