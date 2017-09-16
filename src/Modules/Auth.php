<?php

namespace ThemeAnorak\LaravelShopify\Modules;


use ThemeAnorak\LaravelShopify\Client;
use Dpc\HashVerifier\AuthValidatorContract;
use ThemeAnorak\LaravelShopify\Exceptions\HashFailedException;
use ThemeAnorak\LaravelShopify\Exceptions\InvalidHostException;
use ThemeAnorak\LaravelShopify\Exceptions\NonceFailedException;

class Auth
{
    protected $client;

    protected $validator;

    /**
     * Auth constructor.
     * @param Client $client
     * @param AuthValidatorContract $validator
     */
    public function __construct(Client $client, AuthValidatorContract $validator)
    {
        $this->client = $client;
        $this->validator = $validator;

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
        if(!$this->validator->matches($user,data_get($uriComponents, 'nonce'))) {
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
        return dns_check_record($host) && filter_var($host);
    }

    public function getUriComponents(string $url)
    {
        parse_str(ltrim(strstr($url, '?'), '?'), $components);
        return $components;
    }

    public function fetchToken(array $uriComponents): string
    {
        $response = $this->client->getRequest()->post('oauth/access_token', [
            'client_id' => $this->client->getKey(),
            'client_secret' => $this->client->getSecret(),
            'code' => data_get($uriComponents, 'code'),
        ]);

        return data_get($response, 'token');
    }



}