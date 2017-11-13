<?php

namespace ThemeAnorak\LaravelShopify\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ShopifyAuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
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