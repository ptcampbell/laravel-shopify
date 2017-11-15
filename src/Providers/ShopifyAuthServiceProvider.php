<?php

namespace ThemeAnorak\LaravelShopify\Providers;

use Middleware\AuthGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ShopifyAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Auth::extend('shopify', function() {
            return new AuthGuard();
        });

        Auth::provider('shopify', function () {
            return new ShopifyUserProvider();
        });
    }

    /**
     * Register any application services.;
     *
     * @return void
     */
    public function register()
    {
    }
}