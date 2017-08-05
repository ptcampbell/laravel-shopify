<?php

namespace Dpc\LaravelShopify\Exceptions;


class NonceFailedException extends \Exception
{

    /**
     * NonceFailedException constructor.
     */
    public function __construct()
    {
        parent::__construct('Authentication failed because nonce does not match');
    }
}