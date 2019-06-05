<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Type\Zend;

use PHPUnit\Framework\TestCase;
use ZendPhpStan\Type\Zend\ObjectServiceManagerType;

/**
 * @covers \ZendPhpStan\Type\Zend\ObjectServiceManagerType
 */
final class ObjectServiceManagerTypeTest extends TestCase
{
    public function testTrivialUsage()
    {
        $className                = \stdClass::class;
        $serviceName              = 'FooBar';
        $objectServiceManagerType = new ObjectServiceManagerType($className, $serviceName);

        static::assertSame($className, $objectServiceManagerType->getClassName());
        static::assertSame($serviceName, $objectServiceManagerType->getServiceName());
    }
}
