<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserModelServiceProvider extends ServiceProvider
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
    public function boot(): void{
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
