<?php

namespace ThemeAnorak\LaravelShopify\Modules;


class Metafield extends BaseModule
{

    protected function prepareUri(string $uri = ''): string
    {
        if ($uri) {
            $url = $this->parent ? key($this->parent) : "metafields/$uri";
        } else {
            $url = 'metafields.json';
        }

        return url($url, $this->params);
    }

    public function since(int $id): Metafield
    {
        $this->params['sinceId'] = $id;
        return $this;
    }
}