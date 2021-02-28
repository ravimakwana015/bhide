<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }
    // public function login(Request $request)
    // {

    public function showLoginForm()
    {
        return redirect()->route('landing.page');
    }
    //   // Validate the form data
    //     $this->validate($request, [
    //         'email'   => 'required|email',
    //         'password' => 'required|min:8'
    //     ]);
    //     $user=User::where('email',$request->email)->first();
    //     if(isset($user)){
    //         if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
    //             return redirect($this->redirectTo);
    //         }
    //     }
    //     return redirect()->back()->with('error', trans('These credentials do not match our records.'));
    // }


    public function login(Request $request)
    {
      $logindata = $request->all();

      $rules = array('email' => 'required', 'password' => 'required|min:6');
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json(array(
          'status' => false,
          'msg' => $validator->errors()->all(),
        ));
      }
      else
      {
        $login = request()->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$fieldType => $login]);
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) 
        {
          if (Auth::guard()->attempt(['email' => $logindata['email'], 'password' => $logindata['password']], $request->remember)) 
          {
            return response()->json(array(
              'status' => true,
              'msg' => 'Login Successful',
            ));
          }
          else
          {
            return response()->json(array(
              'status' => false,
              'msg' => 'Invalid Email or Password , Please try again.',
            ));
          }
        } 
        else 
        {
          return response()->json(array(
            'status' => false,
            'msg' => 'Invalid Email or Password , Please try again.',
          ));
        }
      } 
    }

  }

