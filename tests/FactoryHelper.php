<?php

namespace Dpc\LaravelShopify\Tests;


trait FactoryHelper
{
    public function factory()
    {
        $model = new ModelStub();
        $model->foo = 'bar';

        return $model;
    }

}
