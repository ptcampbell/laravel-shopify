<?php

namespace Middleware;


use Providers\ShopifyUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use ThemeAnorak\LaravelShopify\Contracts\ShopifyFactoryContract;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class AuthGuard implements Guard
{

    protected $store;

    protected $factory;

    /**
     * AuthGuard constructor.
     * @param $store
     */
    public function __construct(TokenStoreContract $store, ShopifyFactoryContract $factory)
    {
        $this->store = $store;
        $this->factory = $factory;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->store->has();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return new ShopifyUser($this->store->get());
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        return $this->store->get();
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {

    }
}

