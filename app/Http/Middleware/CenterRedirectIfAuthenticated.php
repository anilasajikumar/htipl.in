<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CenterRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('center')->check())
        {
            return redirect('/study-center/dashboard');
        }
        else
        {
            return $next($request);
        };
    }   
}
