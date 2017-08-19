<?php

namespace ThemeAnorak\LaravelShopify\Modules;


class Image extends BaseModule
{
    protected function prepareUri(string $uri = 'images.json'): string
    {
        if ($this->parent) {
            return url("products/#$this->parent/$uri", $this->params);
        }

        return url('variants/' . $uri, $this->params);
    }
}