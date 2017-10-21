<?php

namespace ThemeAnorak\LaravelShopify\Modules;


use Illuminate\Support\Facades\Cache;
use ThemeAnorak\LaravelShopify\Client;
use Dpc\HashVerifier\AuthValidatorContract;
use Dpc\HashVerifier\Exceptions\HashFailedException;
use Dpc\HashVerifier\Exceptions\NonceFailedException;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;
use ThemeAnorak\LaravelShopify\Exceptions\InvalidHostException;
use ThemeAnorak\LaravelShopify\Exceptions\TokenNotReceivedException;

class Auth
{
    protected $client;

    protected $validator;

    protected $store;

    /**
     * Auth constructor.
     * @param Client $client
     * @param AuthValidatorContract $validator
     * @param TokenStoreContract $store
     */
    public function __construct(Client $client, AuthValidatorContract $validator, TokenStoreContract $store)
    {
        $this->client = $client;
        $this->validator = $validator;
        $this->store = $store;

    }

    /**
     * @link https://help.shopify.com/api/getting-started/authentication/oauth
     * @param $user
     * @return string
     */
    public function getAuthorisationUrl($user): string
    {
        $domain = $this->client->getDomain();
        return "$domain/admin/oauth/authorize?" . http_build_query([
                'client_id' => $this->client->getKey(),
                'scope' => implode(config('shopify.scopes', []), ','),
                'redirect_uri' => config('shopify.redirect_uri', ''),
                'state' => $this->validator->generateNonce($user),
                'grant-options[]' => 'per-user',
            ]);

    }

    public function confirmAuthorisation($user, string $url)
    {
        $uriComponents = $this->getUriComponents($url);
        if(!$this->validator->matches($user, data_get($uriComponents, 'state'))) {
            throw new NonceFailedException();
        }

        if (!$this->validator->validate($uriComponents)) {
            throw new HashFailedException();
        }

        if (!$this->isValidHost($uriComponents)) {
            throw new InvalidHostException();
        }

        return $this->fetchToken($uriComponents);
    }

    protected function isValidHost(array $uriComponents)
    {
        $host = data_get($uriComponents, 'shop');
        return dns_check_record($host);
    }

    public function getUriComponents(string $url)
    {
        parse_str(ltrim(strstr($url, '?'), '?'), $components);
        return $components;
    }

    public function fetchToken(array $uriComponents): string
    {
        $response = $this->client->getRequest()->asGuest()->post('oauth/access_token', [
            'client_id' => $this->client->getKey(),
            'client_secret' => $this->client->getSecret(),
            'code' => data_get($uriComponents, 'code'),
        ]);

        $token = data_get($response, 'access_token');
        if (!$token) {
            throw new TokenNotReceivedException();
        }

        $this->store->set($token);
        return $token;
    }



}