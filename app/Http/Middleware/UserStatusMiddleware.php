<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_active == false){ // Auth::check() проверяет залогинился или нет
            Auth::logout();
            return redirect()->route('login.form')->withErrors( 'You are banned, call administrator!!!');
        }
        return $next($request);
    }
}
