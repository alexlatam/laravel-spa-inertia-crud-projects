<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
    public function boot(): void
    {
        // Esto define las sesiones de flash para mostrar mensajes de exito o error en vue
        Inertia::share("flash", function() {
            return [
                "success" => session("success"),
                "error" => session("error"),
            ];
        });
    }
}
