<?php

namespace ThemeAnorak\LaravelShopify\Modules;



class Variant extends BaseModule
{
    protected function prepareUri(string $uri = 'variants.json'): string
    {
        if ($this->parent) {
            return url("products/#$this->parentId/$uri", $this->params);
        }

        return url('variants/' . $uri, $this->params);
    }

}