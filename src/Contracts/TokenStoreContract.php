<?php

namespace ThemeAnorak\LaravelShopify\Contracts;


interface TokenStoreContract
{
    public function get() : ?string;

    public function set(string $token);

    public function forget();

    public function has();
    
}