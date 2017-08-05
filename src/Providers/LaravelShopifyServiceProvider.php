<?php

namespace ThemeAnorak\LaravelShopify\Providers;

use Dpc\HashVerifier\AuthValidatorServiceProvider;
use ThemeAnorak\LaravelShopify\Contracts\RequestClientContract;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;
use ThemeAnorak\LaravelShopify\Modules\RelationHandler;
use ThemeAnorak\LaravelShopify\Modules\RelationHandlerContract;
use ThemeAnorak\LaravelShopify\ShopifyFactory;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use ThemeAnorak\LaravelShopify\Services\GuzzleClient;

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
        $this->app->bind(RequestClientContract::class, GuzzleClient::class);
        $this->app->bind(ShopifyFactoryContract::class, ShopifyFactory::class);
        $this->app->bind(RelationHandlerContract::class, RelationHandler::class);
        $this->app->bind(Client::class, function () {
            return new Client([
                'base_uri' => config('shopify.domain'),
            ]);
        });

    }
}