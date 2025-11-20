<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActive
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda nonaktif. Hubungi admin.',
            ]);
        }

        return $next($request);
    }
}

