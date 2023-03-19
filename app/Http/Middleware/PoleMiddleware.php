<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$rolenames): Response
    {
        if (Auth::check()){ // Auth::check() проверяет залогинился или нет
            foreach ($rolenames as $rname){
                if(Auth::user()->role->name == $rname){ // Auth::user() кирип турган юзердин обект кайтарады
                    return $next($request);
                }
            }
        }
        else{
            return redirect()->route('login.form');
        }
        return response()->view('errors.nopermission');
    }
}
