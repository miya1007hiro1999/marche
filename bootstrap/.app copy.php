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

            // Route::middleware('web')
            //     ->prefix('owner')
            //     ->as('owner.')
            //     // ->namespace($this->namespace)
            //     ->group(base_path('routes/owner.php'));

            // Route::middleware('web')
            //     ->prefix('admin')
            //     ->as('admin.')
            //     // ->namespace($this->namespace)
            //     ->group(base_path('routes/admin.php'));
        },
    
    )
    ->withMiddleware(function (Middleware $middleware) {
        // laraver8 までの書き方
        // protected $user_route='user.login';
        // protected $owner_route='owner.login';
        // protected $admin_route='admin.login';
        // protected function redirectTo($request)
        // {
        //     if(! $request->expextsJson()){
        //         if(Route::is('owner.*')){
        //             return route($this->owner_route);
        //         }elseif(Route::is('admin.*')){
        //             return route($this->admin_route);
        //         }else{
        //             return route($this->user_route);
        //         }
        //     }
        // }

        $middleware->redirectGuestsTo(function(Request $request) {
            if (request()->Route::is('owner.*')) {
                return $request->expectsJson() ? null : route($this->owner_route);
            }elseif(request()->Route::is('admin.*')) {
                return $request->expectsJson() ? null : route($this->admin_route);
            }
            return $request->expectsJson() ? null : route($this->user_route);
        });

        $middleware->alias([
            'owner'=>Owner::class,
            'admin'=>Admin::class,
            'user'=>User::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
