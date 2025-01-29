<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // public function handle(Request $request, Closure $next, ...$roles)
    // {
    //     if (Auth::check() && in_array(Auth::user()->role, $roles)) {
    //         return $next($request);
    //     }

    //     return redirect('/login')->with('error', 'Akses ditolak!');
    // }

    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
