<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
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
        if(!session()->has("LoggedUser") && $request->path() == "addtocart"){
            return redirect("login")->with("fail", "Before you add product(s) to cart, logged in!");
        }
        else if(!session()->has("LoggedUser")){
            return redirect("login")->with("fail", "You must logged in!");
        }
        return $next($request);
    }
}
