<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\View\Components\EjercicioCard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::component('ejercicio-card', EjercicioCard::class);
        
        // Forzar esquema HTTPS en producción (excepto en local)
        if (config('APP_ENV') !== 'local') {
            \URL::forceScheme('https');  // Usar el helper global URL
        }
    }
}
