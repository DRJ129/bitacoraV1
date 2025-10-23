<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventBackHistory;

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
        // Registrar alias de middleware 'admin' para control de acceso por role
        Route::aliasMiddleware('admin', AdminMiddleware::class);
        Route::aliasMiddleware('prevent-back', PreventBackHistory::class);
    }
}
