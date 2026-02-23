<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

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
        if (!app()->environment('local')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Override static config/service_prices.php with live values from the DB.
        // This ensures CMS edits (price changes, discounts) are reflected everywhere
        // on the site without touching the config file.
        try {
            $services = \App\Models\Service::select('slug', 'base_price', 'discount_price')->get();
            foreach ($services as $svc) {
                $effective = ($svc->discount_price !== null && $svc->discount_price < $svc->base_price)
                    ? (int) $svc->discount_price
                    : (int) $svc->base_price;
                $underscore = str_replace('-', '_', $svc->slug);
                Config::set('service_prices.' . $underscore, $effective);
                Config::set('service_prices.' . $svc->slug,  $effective);
            }
        } catch (\Throwable $e) {
            // Silently skip during artisan commands / fresh installs before migrations run.
        }
    }
}
