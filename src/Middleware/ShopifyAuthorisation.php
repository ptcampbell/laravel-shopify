<?php

namespace ThemeAnorak\LaravelShopify\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class ShopifyAuthorisation
{
    protected $factory;

    protected $store;

    /**
     * ShopifyAuthorisation constructor.
     * @param $factory
     */
    public function __construct(ShopifyFactoryContract $factory, TokenStoreContract $store)
    {
        $this->factory = $factory;
        $this->store = $store;
    }


    public function handle(Request $request, Closure $next)
    {
        if (! $this->store->has()) {
            return redirect($this->factory->auth->getAuthorisationUrl(Auth::user()));
        }

        return $next($request);

    }

}