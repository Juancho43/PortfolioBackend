<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Session\Middleware\AuthenticateSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
web: __DIR__.'/../routes/web.php',
api: __DIR__.'/../routes/api.php',
commands: __DIR__.'/../routes/console.php',
health: '/up',
)
->withMiddleware(function (Middleware $middleware) {
// Configuración específica para Sanctum
$middleware->api(prepend: [
 EnsureFrontendRequestsAreStateful::class,
]);

// Alias de middlewares para Sanctum
$middleware->alias([
'auth' => Authenticate::class,
'auth.basic' => AuthenticateWithBasicAuth::class,
'auth.session' => AuthenticateSession::class,
]);

// Middleware para web (si necesitas autenticación de sesión)
$middleware->web(append: [
HandleCors::class,
]);
})
->withExceptions(function (Exceptions $exceptions) {
//
})->create();
