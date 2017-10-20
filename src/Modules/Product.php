<?php

namespace ThemeAnorak\LaravelShopify\Modules;

class Product extends BaseModule
{
    public function since(int $id): Product
    {
        $this->params['sinceId'] = $id;
        return $this;
    }

    public function fields(array $fields): Product
    {
        $this->params['fields'] = $fields;
        return $this;
    }

    public function ofCollection(int $collectionId): Product
    {
        $this->params['collection_id'] = $collectionId;
        return $this;
    }

    protected function prepareUri(string $uri = ''): string
    {
        $url = $uri ? 'products/' . $uri : 'products.json';
        return $this->generateUri($url);
    }

}