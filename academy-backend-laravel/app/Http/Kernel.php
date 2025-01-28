<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
//        'auth' => \App\Http\Middleware\Authenticate::class,
//        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'role' => \App\Http\Middleware\CheckRole::class,
        'cors' => \App\Http\Middleware\Cors::class,
    ];

    protected $middleware = [
        \App\Http\Middleware\Cors::class,
    ];
}
