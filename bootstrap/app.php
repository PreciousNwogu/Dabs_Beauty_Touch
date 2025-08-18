<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register custom middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // HTTPS is handled by Render proxy - no need for custom redirect middleware
        // Force HTTPS only in production
        // if (env('APP_ENV') === 'production') {
        //     $middleware->web(append: [
        //         \App\Http\Middleware\ForceHttps::class,
        //     ]);
        // }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
