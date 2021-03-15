<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($guard == "admin"){
                return redirect()->route('admin.home');
            } else if($guard == "seller"){
                return redirect()->route('seller.home');
            } else {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
