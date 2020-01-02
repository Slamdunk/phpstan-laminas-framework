<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Type\Laminas;

use LaminasPhpStan\Type\Laminas\ObjectServiceManagerType;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \LaminasPhpStan\Type\Laminas\ObjectServiceManagerType
 */
final class ObjectServiceManagerTypeTest extends TestCase
{
    public function testTrivialUsage(): void
    {
        $className                = stdClass::class;
        $serviceName              = 'FooBar';
        $objectServiceManagerType = new ObjectServiceManagerType($className, $serviceName);

        self::assertSame($className, $objectServiceManagerType->getClassName());
        self::assertSame($serviceName, $objectServiceManagerType->getServiceName());
    }
}
