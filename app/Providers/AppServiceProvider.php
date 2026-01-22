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
        // Force HTTPS in any non-local environment.
        // This prevents Render/staging from generating http:// form actions/links which triggers browser "not secure" warnings.
        if (!app()->environment('local')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
