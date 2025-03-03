<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::user()->is_admin && $role === 'admin') {
            return $next($request);
        } elseif (!Auth::user()->is_admin && $role === 'staff') {
            return $next($request);
        }
        dd($role);
        return redirect()->route('loginAdmin');
    }
}
