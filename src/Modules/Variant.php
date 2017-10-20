<?php

namespace ThemeAnorak\LaravelShopify\Modules;



class Variant extends BaseModule
{
    protected function prepareUri(string $uri = 'variants.json'): string
    {
        $url = $this->parent ? "products/#$this->parent/$uri" : "variants/$uri";
        return $this->generateUri($url);
    }

}