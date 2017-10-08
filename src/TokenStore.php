<?php

namespace ThemeAnorak\LaravelShopify;

use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Model;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class TokenStore implements TokenStoreContract
{

    protected $cache;

    /**
     * TokenStore constructor.
     * @param $cache
     */
    public function __construct(Store $cache)
    {
        $this->cache = $cache;
    }

    public function get(Model $user): ?string
    {
        return $this->cache->get($user->id . 'shopify_token');
    }

    public function set(Model $user, string $token): void
    {
        $this->cache->put($user->id . 'shopify_token', $token, config('shopify.token_timout', 60));
    }

    public function forget(Model $user): bool
    {
        return $this->cache->forget('token');
    }
}