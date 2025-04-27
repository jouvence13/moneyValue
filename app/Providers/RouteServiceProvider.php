<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
          // Ajout du fichier api_v2.php
          Route::middleware('api')
          ->prefix('api')
          ->group(base_path('routes/api.php'));
    }
}
