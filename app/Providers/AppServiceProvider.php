<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema; // <-- Ajoutez cette ligne

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Gamma Service
        $this->app->singleton(\App\Services\Ai\GammaService::class, function ($app) {
            return new \App\Services\Ai\GammaService(
                config('services.gamma.api_key')
            );
        });

        // Register OpenAI Image Service
        $this->app->singleton(\App\Services\Ai\OpenAIImageService::class, function ($app) {
            return new \App\Services\Ai\OpenAIImageService(
                config('services.openai.api_key')
            );
        });

        // Register Twilio Service
        $this->app->singleton(\App\Services\TwilioService::class, function ($app) {
            return new \App\Services\TwilioService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // AJOUTEZ CETTE LIGNE POUR RÉGLER L'ERREUR 1071 DE MYSQL
        Schema::defaultStringLength(191);
    }
}