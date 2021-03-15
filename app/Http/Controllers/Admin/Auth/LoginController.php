<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public $maxAttempts = 5;
    public $decayMinutes = 3;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login', [
            'title' => 'Admin Login',
            'loginRoute' => 'admin.login',
            'forgotPasswordRoute' => 'admin.password.request',
        ]);
    }

    public function login(Request $request)
    {
        $this->validator($request);

        /*
        * Optional
        */

        //check if the user has too many login attempts.
        if ($this->hasTooManyLoginAttempts($request)) {
            //Fire the lockout event.
            $this->fireLockoutEvent($request);

            //redirect the user back after lockout.
            return $this->sendLockoutResponse($request);
        }

        /*
        * End Optional
        */


        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            return redirect()
                ->intended(route('admin.home'))
                ->with('status', 'You are Logged in as Admin!');
        }

        /*
        * Optional
        */

        //keep track of login attempts from the user.
        $this->incrementLoginAttempts($request);

        /*
        * End Optional
        */

        //Authentication failed...
        return $this->loginFailed();
    }


    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email' => 'required|email|min:5|exists:admins|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }

    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login failed, please try again!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.login')
            ->with('status', 'Admin has been logged out!');
    }

    public function username()
    {
        return 'email';
    }

}
