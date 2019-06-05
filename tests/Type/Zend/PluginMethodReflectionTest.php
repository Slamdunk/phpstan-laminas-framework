<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Type\Zend;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;
use ZendPhpStan\Type\Zend\PluginMethodReflection;

/**
 * @covers \ZendPhpStan\Type\Zend\PluginMethodReflection
 */
final class PluginMethodReflectionTest extends TestCase
{
    public function testTrivialUsage()
    {
        $declaringClass = $this->createMock(ClassReflection::class);
        $methodName     = 'redirect';
        $returnType     = new ObjectType(\stdClass::class);

        $pluginMethodReflection = new PluginMethodReflection($declaringClass, $methodName, $returnType);

        static::assertSame($declaringClass, $pluginMethodReflection->getDeclaringClass());
        static::assertSame($pluginMethodReflection, $pluginMethodReflection->getPrototype());
        static::assertFalse($pluginMethodReflection->isStatic());
        static::assertFalse($pluginMethodReflection->isPrivate());
        static::assertTrue($pluginMethodReflection->isPublic());
        static::assertSame($methodName, $pluginMethodReflection->getName());

        $variants = $pluginMethodReflection->getVariants();

        static::assertCount(1, $variants);

        $variant = \current($variants);

        static::assertInstanceOf(FunctionVariant::class, $variant);
    }
}
