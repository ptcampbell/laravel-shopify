<?php

namespace ThemeAnorak\LaravelShopify\Exceptions;


class ParentResourceNotSpecifiedException extends \Exception
{

    /**
     * ParentResourceNotSpecifiedExeption constructor.
     */
    public function __construct()
    {
        parent::__construct('Parent resource not specified');

    }
}