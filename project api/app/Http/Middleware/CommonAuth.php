<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CommonAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('userType'))
            return $next($request);
        else
            return redirect()->route('loginUser')->with(session()->flash('alert-danger', 'You do not have permission to access this page!!!'));
    }
}