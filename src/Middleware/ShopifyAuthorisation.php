<?php

namespace ThemeAnorak\LaravelShopify\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;

class ShopifyAuthorisation
{
    public function handle(Request $request, Closure $next, ShopifyFactoryContract $factory)
    {
        if (!$request->header('token')) {
            $factory->auth->getAuthorisationUrl(Auth::user());
        }

        return $next($request);

    }

}