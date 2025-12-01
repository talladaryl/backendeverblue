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
        api: __DIR__ . '/../routes/api.php', 
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Cookies
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        /**
         * CORS (Laravel natif)
         */
        $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);

        // Web middleware
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        /**
         * API Middleware
         * ❌ On ignore Sanctum et CSRF pour l'API
         */
        $middleware->api(prepend: [
            // Si tu veux, tu peux supprimer EnsureFrontendRequestsAreStateful
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configuration des exceptions
    })
    ->create();