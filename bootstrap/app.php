<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', // Assurez-vous que les routes API sont bien chargées
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Cookies
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        // CORS Middleware sur toutes les routes
        $middleware->prepend(\App\Http\Middleware\CorsMiddleware::class);

        // Middlewares pour Web
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // Middlewares pour API
        $middleware->api(prepend: [
            // Gère les SPA stateful (React + Sanctum)
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // Autres middlewares API nécessaires, si besoin
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configurations des exceptions
    })
    ->create();