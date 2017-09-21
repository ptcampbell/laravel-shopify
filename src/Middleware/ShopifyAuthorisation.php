<?php

namespace ThemeAnorak\LaravelShopify\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;

class ShopifyAuthorisation
{
    protected $factory;

    /**
     * ShopifyAuthorisation constructor.
     * @param $factory
     */
    public function __construct(ShopifyFactoryContract $factory)
    {
        $this->factory = $factory;
    }


    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            throw new AuthenticationException();
        }

        if (!$request->hasHeader('token')) {
            return redirect($this->factory->auth->getAuthorisationUrl(Auth::user()));
        }

        return $next($request);

    }

}