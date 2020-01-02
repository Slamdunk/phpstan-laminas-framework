<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\Stdlib\ArrayObject;

final class stdlibArrayObjectCrate
{
    public function foo(): void
    {
        $arrayObject      = new ArrayObject();
        $arrayObject->foo = 123;
        $arrayObject->foo();
    }
}
