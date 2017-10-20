<?php

namespace ThemeAnorak\LaravelShopify\Exceptions;


class TokenNotReceivedException extends \Exception
{

    /**
     * TokenNotReceivedException constructor.
     */
    public function __construct()
    {
        parent::__construct('No token received from login', 422);
    }
}