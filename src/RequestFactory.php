<?php

namespace Dpc\LaravelShopify;

use Dpc\LaravelShopify\Contracts\RequestClientContract;
use GuzzleHttp\Exception\RequestException;

class RequestFactory
{
    protected $request;

    protected $collection;

    /**
     * Request constructor.
     * @param RequestClientContract $request
     */
    public function __construct(RequestClientContract $request)
    {
        $this->request = $request;
    }

    public function __call($method, $args)
    {
        list($uri, $data, $token) = array_pad($args, 3, null);

        if ($token) {
            $data[] = [
                'token' => $token
            ];
        }

        $uri = '/admin/' . $uri;

        try {
            $response = $this->request->send($method, $uri, $data);
        } catch (RequestException $requestException) {
            $response = $requestException->getMessage();
        }
        return $response;

    }

}