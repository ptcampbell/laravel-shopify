<?php

namespace ThemeAnorak\LaravelShopify\Modules;


class Image extends BaseModule
{
    protected function prepareUri(string $uri = 'images.json'): string
    {
        if ($this->parent) {
            return $this->generateUri("products/#$this->parent/$uri");
        }

        return $this->generateUri('variants/' . $uri);
    }
}