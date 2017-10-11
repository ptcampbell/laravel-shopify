<?php

namespace ThemeAnorak\LaravelShopify;

use Illuminate\Support\Facades\Session;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class TokenStore implements TokenStoreContract
{


    public function get(): ?string
    {
        return Session::get('shopify_token');
    }

    public function set(string $token): void
    {
        Session::put('shopify_token', $token);
    }

    public function forget(): bool
    {
        return Session::forget('shopify_token');
    }

    public function has()
    {
        return Session::has('shopify_token');

    }
}