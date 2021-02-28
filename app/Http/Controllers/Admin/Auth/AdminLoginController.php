<?php

namespace App\Http\Controllers\Admin\Auth;

use Session;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use App\Admin;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $admin_user = Admin::where('email', '=', $request->email)->first();
        if (isset($admin_user) && Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('admin.home');
        }
        Session::flash('error', "Invalid Email or Password , Please try again.");
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }
}
