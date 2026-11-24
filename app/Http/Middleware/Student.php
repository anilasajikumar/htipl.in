<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
Use Session;


class Student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::guard('student')->check())
        {
            if(Auth::guard('student')->user()->status == '0')
            {
                Auth::guard('student')->logout();
                return redirect('login');
            }
            return $next($request);
        }
        else
        {
        return redirect('login');
    };
}
}

