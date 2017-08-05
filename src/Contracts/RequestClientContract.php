<?php

namespace Dpc\LaravelShopify\Contracts;


interface RequestClientContract
{
    public function send(string $method, string $uri, ?array $body = null, ?array $headers = null, ?array $options = null);

}