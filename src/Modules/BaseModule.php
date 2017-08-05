<?php

namespace Dpc\LaravelShopify\Modules;

use Dpc\LaravelShopify\Client;

abstract class BaseModule
{
    protected $client;

    protected $relationHandler;

    protected $parentId;

    /**
     * BaseModule constructor.
     * @param $client
     */
    public function __construct(Client $client, RelationHandlerContract $relationHandler)
    {
        $this->client = $client;
        $this->relationHandler = $relationHandler;
    }

    abstract protected function prepareUri(string $uri = ''): string;


    public function get()
    {
        return $this->client->getRequest()->get($this->prepareUri());
    }

    public function count()
    {
        return $this->client->getRequest()->get($this->prepareUri('count.json'));
    }

    public function first(int $id)
    {
        $results = $this->client->getRequest()->get($this->prepareUri("#$id.json"));
        if ($results) {
            $results['related'] = $this->relationHandler->loadRelations($results);
        }
    }

    public function create(array $product)
    {
        return $this->client->getRequest()->post($this->prepareUri(), $product);
    }

    public function update(int $id, array $product)
    {
        return $this->client->getRequest()->update($this->prepareUri("#$id.json"), $product);
    }

    public function with($relations): BaseModule
    {
        $this->relations = $relations;
        return $this;
    }

    public function belongsTo($id): BaseModule
    {
        $this->parentId = $id;
        return $this;
    }

}