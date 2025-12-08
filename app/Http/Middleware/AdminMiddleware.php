<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika belum login → redirect ke login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika bukan admin → redirect ke dashboard user
        if (Auth::user()->role !== 'admin') {
            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}