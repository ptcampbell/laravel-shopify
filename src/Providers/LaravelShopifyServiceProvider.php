<?php

namespace ThemeAnorak\LaravelShopify\Providers;

use Illuminate\Support\ServiceProvider;
use Dpc\GuzzleClient\GuzzleClientServiceProvider;
use Dpc\HashVerifier\AuthValidatorServiceProvider;
use ThemeAnorak\LaravelShopify\Modules\RelationHandler;
use ThemeAnorak\LaravelShopify\Modules\RelationHandlerContract;

class LaravelShopifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/shopify.php' => config_path('shopify.php'),
        ], 'config');

    }

    /**
     * Register any application services.;
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthValidatorServiceProvider::class);
        $this->app->register(GuzzleClientServiceProvider::class);
        $this->app->bind(RelationHandlerContract::class, RelationHandler::class);
    }
}