<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;


class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->roles->name === UserRole::ROLE_ADMIN) {
            return $next($request);
        }

        // Log out the user
        Auth::logout();

        // Return a 403 Forbidden response
        return response()->json(['message' => 'Sorry!!! You are not an admin'], 403);
    }
}
