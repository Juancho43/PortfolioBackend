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
    ->withMiddleware(function (Middleware $middleware) {
        // Para rutas API específicamente
        $middleware->api(append: [
            \App\Http\Middleware\Authenticate::class,
        ]);

        // O si quieres para rutas web:
        // $middleware->web(append: [
        //     \App\Http\Middleware\Authenticate::class,
        // ]);

        // O si quieres para todas las rutas (global):
        // $middleware->append([
        //     \App\Http\Middleware\Authenticate::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
