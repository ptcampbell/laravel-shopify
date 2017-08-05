<?php

namespace ThemeAnorak\LaravelShopify\Modules;



class Variant extends BaseModule
{
    protected $params;

    protected $parentId;


    protected function prepareUri(string $uri = 'variants.json'): string
    {
        if ($this->parentId) {
            return url("products/#$this->parentId/$uri", $this->params);
        }

            return url('variants/' . $uri, $this->params);
    }

}