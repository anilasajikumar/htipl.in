<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Centers;
use Illuminate\Support\Facades\Auth;
Use Session;


class Center
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

        if(Auth::guard('center')->check())
        {
            if(Auth::guard('center')->user()->status == '0')
            {
                Auth::guard('center')->logout();
                return redirect('study-center/login');
            }
            return $next($request);
        }
        else
        {
        return redirect('study-center/login');
    };
}
}

