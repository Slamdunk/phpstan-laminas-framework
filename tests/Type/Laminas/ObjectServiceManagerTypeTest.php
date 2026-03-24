<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Type\Laminas;

use LaminasPhpStan\Type\Laminas\ObjectServiceManagerType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(ObjectServiceManagerType::class)]
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
