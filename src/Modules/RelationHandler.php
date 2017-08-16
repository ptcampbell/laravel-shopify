<?php
/**
 * Created by PhpStorm.
 * User: dpc
 * Date: 1/8/17
 * Time: 6:36 PM
 */

namespace ThemeAnorak\LaravelShopify\Modules;

use ThemeAnorak\LaravelShopify\ShopifyFactory;

class RelationHandler implements RelationHandlerContract
{
    protected $factory;

    protected $relations = [];

    /**
     * RelationHandler constructor.
     * @param $factory
     * @param $relations
     */
    public function __construct(ShopifyFactory $factory)
    {
        $this->factory = $factory;
    }

    public function isRelationSet(): bool
    {
        return !empty($this->relations);
    }

    public function loadRelations(array $results): array
    {
        $related = [];
        foreach ($this->relations as $relation => $type) {
            $belongsTo = $this->factory->$relation->belongsTo([
                $relation => data_get($results, 'id')
            ]);
            $related[$relation] = $type === 'count' ? $belongsTo->count() : $belongsTo->get();
        }
        return $related;
    }

}