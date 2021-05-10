<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\ObjectType;

final class PluginMethodReflection implements MethodReflection
{
    private ClassReflection $declaringClass;

    private string $name;

    private ObjectType $returnType;

    public function __construct(
        ClassReflection $declaringClass,
        string $name,
        ObjectType $returnType
    ) {
        $this->declaringClass = $declaringClass;
        $this->name           = $name;
        $this->returnType     = $returnType;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->declaringClass;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getDocComment(): ?string
    {
        return null;
    }

    public function isDeprecated(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function getDeprecatedDescription(): ?string
    {
        return null;
    }

    public function isFinal(): TrinaryLogic
    {
        return TrinaryLogic::createYes();
    }

    public function isInternal(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function getThrowType(): ?\PHPStan\Type\Type
    {
        return null;
    }

    public function hasSideEffects(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return [
            new FunctionVariant(
                TemplateTypeMap::createEmpty(),
                null,
                [],
                false,
                $this->returnType
            ),
        ];
    }
}
