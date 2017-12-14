<?php

namespace ThemeAnorak\LaravelShopify;


use Dpc\HashVerifier\NonceContract;
use ThemeAnorak\LaravelShopify\Client;
use Dpc\HashVerifier\AuthValidatorContract;
use Dpc\HashVerifier\HMacValidatorContract;
use Dpc\HashVerifier\Exceptions\HashFailedException;
use Dpc\HashVerifier\Exceptions\NonceFailedException;
use ThemeAnorak\LaravelShopify\Contracts\AuthContract;
use ThemeAnorak\LaravelShopify\Contracts\TokenStoreContract;
use ThemeAnorak\LaravelShopify\Exceptions\InvalidHostException;
use ThemeAnorak\LaravelShopify\Exceptions\TokenNotReceivedException;

class Auth implements AuthContract
{
    protected $client;

    protected $generator;

    protected $validator;

    protected $store;

    /**
     * Auth constructor.
     * @param Client $client
     * @param NonceContract $generator
     * @param HMacValidatorContract $validator
     * @param TokenStoreContract $store
     */
    public function __construct(Client $client, NonceContract $generator, HMacValidatorContract $validator, TokenStoreContract $store)
    {
        $this->client = $client;
        $this->generator = $generator;
        $this->validator = $validator;
        $this->store = $store;

    }

    /**
     * @link https://help.shopify.com/api/getting-started/authentication/oauth
     * @return string
     */
    public function getAuthorisationUrl(): string
    {
        $domain = $this->client->getDomain();
        return "$domain/admin/oauth/authorize?" . http_build_query([
                'client_id' => $this->client->getKey(),
                'scope' => implode(config('shopify.scopes', []), ','),
                'redirect_uri' => config('shopify.redirect_uri', ''),
                'state' => $this->generator->generateNonce(),
                'grant-options[]' => 'per-user',
            ]);

    }

    public function confirmAuthorisation(string $url)
    {
        $uriComponents = $this->getUriComponents($url);

        $nonce = $this->generator->getStoredNonce();
        if(!$this->generator->matches($nonce, data_get($uriComponents, 'state'))) {
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

        $token = array_first($response);
        if (!$token) {
            throw new TokenNotReceivedException();
        }

        $this->store->set($token);
        return $token;
    }

}