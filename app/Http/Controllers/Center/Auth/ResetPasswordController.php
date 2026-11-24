<?php

namespace App\Http\Controllers\Center\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Auth;
use Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/study-center/dashboard';

    public function __construct()
    {
        $this->middleware('guest:center');
    }

    public function showResetForm(Request $request, $token = null) {
        return view('auth.passwords.center-reset')
            ->with(['token' => $token, 'study_center_email' => $request->email]
            );
    }


    //defining which guard to use in our case, it's the center guard
    protected function guard()
    {
        return Auth::guard('center');
    }

    //defining our password broker function
    protected function broker() {
        return Password::broker('centers');
    }
}
