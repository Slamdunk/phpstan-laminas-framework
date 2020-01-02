<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Type\Laminas;

use LaminasPhpStan\Type\Laminas\PluginMethodReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\TrinaryLogic;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \LaminasPhpStan\Type\Laminas\PluginMethodReflection
 */
final class PluginMethodReflectionTest extends TestCase
{
    public function testTrivialUsage(): void
    {
        $declaringClass = $this->createMock(ClassReflection::class);
        $methodName     = 'redirect';
        $returnType     = new ObjectType(stdClass::class);

        $pluginMethodReflection = new PluginMethodReflection($declaringClass, $methodName, $returnType);

        self::assertSame($declaringClass, $pluginMethodReflection->getDeclaringClass());
        self::assertSame($pluginMethodReflection, $pluginMethodReflection->getPrototype());
        self::assertFalse($pluginMethodReflection->isStatic());
        self::assertFalse($pluginMethodReflection->isPrivate());
        self::assertTrue($pluginMethodReflection->isPublic());
        self::assertSame($methodName, $pluginMethodReflection->getName());
        self::assertNull($pluginMethodReflection->getDocComment());
        self::assertSame(TrinaryLogic::createNo(), $pluginMethodReflection->isDeprecated());
        self::assertNull($pluginMethodReflection->getDeprecatedDescription());
        self::assertSame(TrinaryLogic::createYes(), $pluginMethodReflection->isFinal());
        self::assertSame(TrinaryLogic::createNo(), $pluginMethodReflection->isInternal());
        self::assertNull($pluginMethodReflection->getThrowType());
        self::assertSame(TrinaryLogic::createNo(), $pluginMethodReflection->hasSideEffects());

        $variants = $pluginMethodReflection->getVariants();

        self::assertCount(1, $variants);

        $variant = \current($variants);

        self::assertInstanceOf(FunctionVariant::class, $variant);
    }
}
