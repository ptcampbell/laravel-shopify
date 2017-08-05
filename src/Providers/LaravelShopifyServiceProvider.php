<?php

namespace Dpc\LaravelShopify\Providers;

use Dpc\HashVerifier\AuthValidatorServiceProvider;
use Dpc\LaravelShopify\Contracts\RequestClientContract;
use Dpc\LaravelShopify\Contracts\ShopifyFactoryContract;
use Dpc\LaravelShopify\Modules\RelationHandler;
use Dpc\LaravelShopify\Modules\RelationHandlerContract;
use Dpc\LaravelShopify\ShopifyFactory;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Dpc\LaravelShopify\Services\GuzzleClient;

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