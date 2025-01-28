<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next): Response
//    {
//        // Handle preflight requests
//        if ($request->isMethod('OPTIONS')) {
//            return response('', 200)
//                ->header('Access-Control-Allow-Origin', '*')
//                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
//                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//        }
//
//        // Handle actual requests
//        $response = $next($request);
//        $response->headers->set('Access-Control-Allow-Origin', '*');
//        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
//        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//
//        return $response;
//    }

    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
