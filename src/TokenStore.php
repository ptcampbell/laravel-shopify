<?php

namespace ThemeAnorak\LaravelShopify;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class TokenStore implements TokenStoreContract
{


    public function get(Model $user): ?string
    {
        return Cache::get($user->id . 'shopify_token');
    }

    public function set(Model $user, string $token): void
    {
        Cache::put($user->id . 'shopify_token', $token, config('shopify.token_timout', 60));
    }

    public function forget(Model $user): bool
    {
        return Cache::forget($user->id . 'shopify_token');
    }

    public function has(Model $user)
    {
        return (bool)$this->get($user);

    }
}