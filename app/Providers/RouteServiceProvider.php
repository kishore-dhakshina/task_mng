<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\JWTMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register your custom middleware alias here
        Route::aliasMiddleware('auth.jwt', JWTMiddleware::class);

        // Load the default routes
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
