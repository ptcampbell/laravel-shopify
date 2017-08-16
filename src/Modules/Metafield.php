<?php

namespace ThemeAnorak\LaravelShopify\Modules;


use ThemeAnorak\LaravelShopify\Exceptions\ParentResourceNotSpecifiedException;

class Metafield extends BaseModule
{

    protected function prepareUri(string $uri = ''): string
    {
        if (! $this->parent) {
            throw new ParentResourceNotSpecifiedException();
        }


        $url = $uri ? key($this->parent) . $uri : 'products.json';
        return url($url, $this->params);
    }
}