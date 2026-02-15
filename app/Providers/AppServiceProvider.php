<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Forzar HTTPS en producción cuando esté detrás de un proxy
        if (config('app.env') === 'production' || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
            
            // Asegurar que APP_URL use HTTPS
            if (config('app.url') && str_starts_with(config('app.url'), 'http://')) {
                config(['app.url' => str_replace('http://', 'https://', config('app.url'))]);
            }
        }
    }
}

