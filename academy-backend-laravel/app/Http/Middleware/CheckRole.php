<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
//        if (Auth::check()) {
//            $user = Auth::user();
//            if ($user->role === $role) {
                return $next($request);
//            }
//        }

        return response()->json(['message' => 'Access denied'], 403);
    }
}
