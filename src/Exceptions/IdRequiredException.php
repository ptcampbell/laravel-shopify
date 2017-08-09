<?php

namespace ThemeAnorak\LaravelShopify\Exceptions;


class IdRequiredException extends \Exception
{
    /**
     * IdRequiredException constructor.
     */
    public function __construct()
    {
        parent::__construct('Id not specified. Id is mandatory for this resource');
    }
}