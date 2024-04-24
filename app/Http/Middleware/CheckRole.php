<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna telah login
        if (!Auth::check()) {
            return Redirect::route('login')->withErrors(['error' => 'Unauthorized action.']);
        }

        // Periksa apakah peran pengguna sesuai dengan salah satu dari peran yang diizinkan
        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles)) {
            return Redirect::back()->withErrors(['error' => 'Unauthorized action.']);
        }

        return $next($request);
    }
}

