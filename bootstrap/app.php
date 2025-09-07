<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
            ->withMiddleware(function (Middleware $middleware): void {
            $middleware->alias([
                'admin' => \App\Http\Middleware\AdminMiddleware::class,
                'instructor' => \App\Http\Middleware\InstructorMiddleware::class,
                'student' => \App\Http\Middleware\StudentMiddleware::class,
            ]);
            
            $middleware->group('web', [
                \Illuminate\Cookie\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);
            
            $middleware->group('api', [
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);
            
            // Register rate limiters
            $middleware->alias([
                'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            ]);
        })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
