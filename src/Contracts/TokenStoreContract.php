<?php

namespace ThemeAnorak\LaravelShopify\Contracts;


use Illuminate\Database\Eloquent\Model;

interface TokenStoreContract
{
    public function get(Model $user) : ?string;

    public function set(Model $user, string $token);

    public function forget(Model $user);
    
}