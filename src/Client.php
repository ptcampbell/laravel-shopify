<?php

namespace Dpc\LaravelShopify;

class Client
{
    protected $domain;

    protected $key;

    protected $secret;

    protected $request;

    /**
     * Client constructor.
     * @param RequestFactory $request
     */
    public function __construct(RequestFactory $request)
    {
        $this->domain = config('shopify.domain');
        $this->key = config('shopify.key');
        $this->secret = config('shopify.secret');
        $this->request = $request;
    }


    public function getDomain() : string
    {
        return $this->domain;

    }

    public function getKey() : string
    {
        return $this->key;
    }

    public function getSecret() : string
    {
        return $this->secret;

    }

    public function getRequest() : RequestFactory
    {
        return $this->request;
    }

}