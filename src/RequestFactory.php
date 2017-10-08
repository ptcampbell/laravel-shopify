<?php

namespace ThemeAnorak\LaravelShopify;

use GuzzleHttp\Exception\RequestException;
use Dpc\GuzzleClient\RequestClientContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;

class RequestFactory
{
    protected $request;

    protected $store;

    protected $guest = false;

    /**
     * Request constructor.
     * @param RequestClientContract $request
     * @param TokenStoreContract $store
     */
    public function __construct(RequestClientContract $request, TokenStoreContract $store)
    {
        $this->request = $request;
        $this->store = $store;
    }

    public function __call($method, $args)
    {
        list($uri, $data) = array_pad($args, 2, null);

        $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
        ];
        if (!$this->guest) {
            $headers['X-Shopify-Access-Token'] = $this->store->get(Auth::user());
        }

        $uri = '/admin/' . $uri;

        try {
            $response = $this->request->send($method, $uri, $data, $headers)
                ->asJson()
                ->json();
        } catch (RequestException $requestException) {
            $response = $requestException->getMessage();
        }
        return $response;

    }

    public function asGuest()
    {
        $this->guest = false;
        return $this;
    }

}