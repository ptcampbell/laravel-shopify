<?php

namespace ThemeAnorak\LaravelShopify\Modules;


interface RelationHandlerContract
{

    public function isRelationSet(): bool;

    public function loadRelations(array $results);
}