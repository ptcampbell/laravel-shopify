<?php

namespace ThemeAnorak\LaravelShopify\Modules;


class Metafield extends BaseModule
{

    protected function prepareUri(string $uri = ''): string
    {
        $endpoint = $uri ? "metafields/$uri" : 'metafields.json';

        if ($this->parent) {
            $key = key($this->parent);
            $url = $key . '/' . $this->parent[$key] . "/$endpoint";
        } else {
            $url = $endpoint;
        }

        return $this->generateUri($url);
    }

    public function since(int $id): Metafield
    {
        $this->params['sinceId'] = $id;
        return $this;
    }
}