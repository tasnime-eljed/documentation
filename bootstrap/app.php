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
    ->withMiddleware(function (Middleware $middleware) {
        // C'EST ICI QUE LA MAGIE OPÈRE ✨
        // On dit à Laravel : "Quand je dis 'admin', utilise AdminMiddleware"
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'reader' => \App\Http\Middleware\ReaderMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
