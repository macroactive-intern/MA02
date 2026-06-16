<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $required = ['APP_KEY', 'APP_ENV', 'DB_CONNECTION'];

        foreach ($required as $var) {
            if (empty(env($var))) {
                throw new \RuntimeException("Required environment variable [{$var}] is not set.");
            }
        }
    }
}
