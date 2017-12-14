<?php

namespace ThemeAnorak\LaravelShopify\Contracts;


interface AuthContract
{
    public function getAuthorisationUrl(): string;

    public function confirmAuthorisation(string $url);

    public function getUriComponents(string $url);

    public function fetchToken(array $uriComponents): string;
}