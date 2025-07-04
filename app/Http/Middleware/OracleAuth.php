<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OracleAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('user_logged')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}