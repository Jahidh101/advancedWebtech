<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\All_user;
use App\Models\Token;

class AdminAuth
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
        $token = Token::where('token', $request->header('Authorization'))->where('expired_at', null)->first();
        if ($token){
            if ($token->all_users->user_types->type == "admin"){
                return $next($request);
            }
            return response()->json("Unauthorized access. You don't have permission to access admin page", 401);
        }
        return response()->json("Unauthorized access", 401);
    }
}
