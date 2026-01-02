<?php

namespace App\Modules\Meal\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('meal')
                ->middleware(['web', 'auth'])
                ->group(__DIR__ . '/../routes/web.php');

            Route::prefix('meal/api')
                ->middleware(['api'])
                ->group(__DIR__ . '/../routes/api.php');
        });
    }
}
