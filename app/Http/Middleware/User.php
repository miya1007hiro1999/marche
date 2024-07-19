<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!AUth::check()){
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if($userRole==1){
            return redirect()->route('owner');
        }

        if($userRole==2){
            return redirect()->route('admin');
        }

        if($userRole==3){
            return $next($request);
        }

        return redirect()->route('user.index');
    }
}
