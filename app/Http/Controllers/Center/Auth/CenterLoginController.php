<?php

namespace App\Http\Controllers\Center\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Toastr;

class CenterLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('center.redirect');
    }

    public function showLoginForm()
    {
    	return view('auth.center-login');
    }

    public function login(Request $request)
    {
    	
    	 $this->validate($request,[
        'email'   => 'required|email',
        'password' => 'required',
      ],['email.email'=>'Please Enter a Valid Email']);

      if (Auth::guard('center')->attempt(['study_center_email' => $request->email, 'password' => $request->password, 'status' => '1'], $request->remember)) {

        Toastr::success('Successfully Logged In', 'success',["positionClass" => "toast-top-center"]);
        Toastr::info('Logged In as center', 'welcome',["positionClass" => "toast-top-center"]);

        return redirect()->intended(route('study-centers'));
      }

      
      return redirect()->back()->withErrors(['email' => 'Invalid Email or Password.'])->withInput($request->only('email', 'remember'));
    }
}
