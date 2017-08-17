<?php

namespace ThemeAnorak\LaravelShopify;

use Illuminate\Contracts\Foundation\Application;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;

class ShopifyFactory implements ShopifyFactoryContract
{
    protected $app;

    /**
     * ShopifyFactory constructor.
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    public function __get($method)
    {
        $class = __NAMESPACE__ . '\\Modules\\' . ucfirst($method);
        return $this->app->make($class);
    }
}