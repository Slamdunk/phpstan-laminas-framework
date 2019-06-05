<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ObjectType;

final class PluginMethodReflection implements MethodReflection
{
    /**
     * @var ClassReflection
     */
    private $declaringClass;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ObjectType
     */
    private $returnType;

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

    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return [
            new FunctionVariant(
                [],
                false,
                $this->returnType
            ),
        ];
    }
}
