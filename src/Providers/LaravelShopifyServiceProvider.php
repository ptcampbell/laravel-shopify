<?php

namespace ThemeAnorak\LaravelShopify\Providers;

use Illuminate\Support\ServiceProvider;
use Dpc\GuzzleClient\GuzzleClientServiceProvider;
use Dpc\HashVerifier\AuthValidatorServiceProvider;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;
use ThemeAnorak\LaravelShopify\Modules\RelationHandler;
use ThemeAnorak\LaravelShopify\Modules\RelationHandlerContract;
use ThemeAnorak\LaravelShopify\ShopifyFactory;
use ThemeAnorak\LaravelShopify\TokenStore;

class LaravelShopifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/shopify.php' => config_path('shopify.php'),
            __DIR__ . '../../config/guzzle.php' => config_path('guzzle.php'),
        ], 'shopify-config');
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
        $this->app->bind(ShopifyFactoryContract::class, ShopifyFactory::class);
        $this->app->bind(TokenStoreContract::class, TokenStore::class);
    }
}