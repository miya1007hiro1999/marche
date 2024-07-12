<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Owner;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware('web')
                ->prefix('/')
                ->as('user.')
                // ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('owner')
                ->as('owner.')
                // ->namespace($this->namespace)
                ->group(base_path('routes/owner.php'));

            Route::middleware('web')
                ->prefix('admin')
                ->as('admin.')
                // ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));
        },
    
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function(Request $request) {
            if (request()->routeIs('owner.*')) {
                return $request->expectsJson() ? null : route('owner.login');
            } elseif (request()->routeIs('admin.*')) {
                return $request->expectsJson() ? null : route('admin.login');
            }else{
                return $request->expectsJson() ? null : route('user.login');
            }
        });

        $middleware->alias([
            'owner' => Owner::class,
            'admin' => Admin::class,
            'user' => User::class,
            // 'Constant'=> App\Constant\Common::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
