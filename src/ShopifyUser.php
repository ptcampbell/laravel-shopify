<?php

namespace ThemeAnorak\LaravelShopify;


use Dpc\SansModelAuth\SansModelUser;

class ShopifyUser extends SansModelUser
{
    protected $token;

    /**
     * ShopifyUser constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }


}