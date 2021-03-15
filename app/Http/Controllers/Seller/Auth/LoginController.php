<?php

namespace App\Http\Controllers\Seller\Auth;

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
        $this->middleware('guest:seller')->except('logout');
    }

    public function showLoginForm()
    {
        return view('seller.auth.login', [
            'title' => 'Seller Login',
            'loginRoute' => 'seller.login',
            'forgotPasswordRoute' => 'seller.password.request',
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


        if (Auth::guard('seller')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            return redirect()
                ->intended(route('seller.home'))
                ->with('status', 'You are Logged in as Seller!');
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
            'email' => 'required|email|min:5|exists:sellers|max:191',
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
        Auth::guard('seller')->logout();
        return redirect()
            ->route('seller.login')
            ->with('status', 'Seller has been logged out!');
    }

    public function username()
    {
        return 'email';
    }
}
