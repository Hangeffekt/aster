<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has("Admintoltotkaposzta")){
            return redirect("admin/profile")->with("fail", "You are already logged in!");
        }
        return $next($request);
    }
}
