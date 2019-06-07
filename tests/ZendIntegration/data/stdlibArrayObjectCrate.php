<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayObject;

final class stdlibArrayObjectCrate
{
    public function foo()
    {
        $arrayObject = new ArrayObject();
        $arrayObject->foo = 123;
        $arrayObject->foo();
    }
}
