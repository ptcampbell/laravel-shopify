<?php

namespace ThemeAnorak\LaravelShopify\Services;

use GuzzleHttp\Client;
use ThemeAnorak\LaravelShopify\Contracts\RequestClientContract;

class GuzzleClient implements RequestClientContract
{
    protected $client;

    /**
     * GuzzleClient constructor.
     */
    public function __construct()
    {
        $this->client = app()->makeWith(Client::class, [
            'base_uri' => config('shopify.domain'),
        ]);
    }

    public function send(string $method, string $uri, ?array $body = null, ?array $headers = null, ?array $options = null)
    {
        return $this->client->request($method, $uri, [
            'form_params' => $body,
            'headers' => $headers,
            'options' => $options,
        ])->getBody();

    }

}