<?php

namespace Providers;


use Dpc\SansModelAuth\AuthServiceContract;
use ThemeAnorak\LaravelShopify\Contracts\AuthContract;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class ShopifyAuthService implements AuthServiceContract
{

    protected $store;

    protected $auth;

    /**
     * ShopifyAuthService constructor.
     * @param $store
     */
    public function __construct(TokenStoreContract $store, AuthContract $auth)
    {
        $this->store = $store;
        $this->auth = $auth;
    }

    /**
     * Determines if current user is authenticated
     */
    public function check(): bool
    {
        return $this->store->has();
    }

    public function setUser(): void
    {
        $this->user = new ShopifyUser($this->store->get();
    }

    public function checkCredentials($credentials): bool
    {
        redirect($this->auth->getAuthorisationUrl());
    }

    public function onLogout(): void
    {
        // TODO: Implement onLogout() method.
    }
}
