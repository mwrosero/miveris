<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

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
        // if (App::environment('production') && config('app.url') !== 'http://localhost') {
        if (config('app.url') !== 'http://localhost') {
            \URL::forceScheme('https');
        }

    }
}
