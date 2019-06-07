<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Stdlib\ArrayObject;

final class stdlibArrayObjectCrate
{
    public function foo()
    {
        $arrayObject      = new ArrayObject();
        $arrayObject->foo = 123;
        $arrayObject->foo();
    }
}
