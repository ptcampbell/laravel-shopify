<?php

namespace ThemeAnorak\LaravelShopify\Modules;

use ThemeAnorak\LaravelShopify\Exceptions\IdRequiredException;

class Asset extends BaseModule
{
    protected $bucket;

    protected $key;

    protected $theme;

    protected function prepareUri(string $uri = ''): string
    {
        if ($uri) {
            throw new IdRequiredException();
        }
        return url("themes/$uri/assets.json", $this->params);
    }

    public function fromBucket(string $bucket): Asset
    {
        $this->bucket = $bucket;
        return $this;
    }

    public function withKey(string $key): Asset
    {
        $this->key = $key;
        return $this;
    }

    public function first(int $id)
    {
        $this->params = array_merge($this->params, [
            'asset_key' => "$this->bucket/$this->key",
            'theme_id' => $id
        ]);

        return $this->client->getRequest()->get($this->prepareUri("#$id.json"));
    }

}