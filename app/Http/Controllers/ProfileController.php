<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Auth;
use App\User;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $company = Auth::user()->company;
        
        $this->validate($request, [
            'company_name' => 'required',
            'person_name' => 'required',
            'mobile' => 'required|unique:companies,mobile,' . $company->id,
            'landline' => 'required|unique:companies,landline,' . $company->id,
            'company_address' => 'required',
        ]);
        $input = $request->all();
        
        if(isset($input['image_name']))
        {
            $company->update([
                'company_name' => $input['company_name'],
                'person_name' => $input['person_name'],
                'mobile' => $input['mobile'],
                'landline' => $input['landline'],
                'company_address' => $input['company_address'],
                'building_image' => $input['image_name'],
            ]);
        }
        else
        {
            $company->update([
                'company_name' => $input['company_name'],
                'person_name' => $input['person_name'],
                'mobile' => $input['mobile'],
                'landline' => $input['landline'],
                'company_address' => $input['company_address'],
                'building_image' => $company->building_image,
            ]);
            
        }
        
        $company->companyUser->update([
            'name' => $input['person_name']
        ]);
        return back()->withStatus(__('Company details updated Successfully !!'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }



    public function uploadImage(Request $request)
    {
        $input = $request->all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = public_path('/upload/') . $image_name;
        file_put_contents($path, $data);
        if (isset($input['id'])) {
            $career = Career::find($input['id']);
            if ($career->icon != '' && file_exists(public_path('img/career_icon/') . $career->icon)) {
                unlink(public_path('img/career_icon/') . $career->icon);
            }
            $career->update(['icon' => $image_name]);
        }
        echo $image_name;
    }



    public function ChangePassword(Request $request)
    {
        return view('profile.change-password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed|different:old_password',
            'password_confirmation' => 'required|min:8',
        ]);
        $userData = User::where('id', Auth::id())->first();
        if (Hash::check($request->old_password, $userData->password)) {
            $userData->update(['password' => Hash::make($request->get('password'))]);
            return back()->withStatus(__('Password Change successfully.'));
        } else {
            return back()->with('error', 'The old password you have entered is incorrect.');
        }
    }

    public function uploadBuildingIcon(Request $request)
    {
        $input = $request -> all();

        list($type, $input['image']) = explode(';', $input['image']);
        list(, $input['image']) = explode(',', $input['image']);

        $data = base64_decode($input['image']);
        $image_name = time() . '.png';
        $path = public_path('front/building_image/').$image_name;
        //$path = '/public/front/building_image/'.$image_name;

        file_put_contents($path, $data);

        echo $image_name;
    }
}
