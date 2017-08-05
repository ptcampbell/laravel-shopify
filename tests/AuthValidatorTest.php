<?php

namespace Dpc\LaravelShopify\Tests;

use Dpc\HashVerifier\AuthValidator;
use Dpc\HashVerifier\HMacValidator;
use Dpc\HashVerifier\NonceGenerator;
use \PHPUnit\Framework\TestCase;

class AuthValidatorTest extends TestCase
{
    use FactoryHelper;

    public function testIfItGeneratesANonce()
    {
        $generator = new NonceGenerator();
        $validator = new HMacValidator();
        $authValidator = new AuthValidator($generator, $validator);

        $model = $this->factory();
        dd($authValidator->generateNonce($model));


    }
    

    
    
    


}