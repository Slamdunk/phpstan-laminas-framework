<?php

namespace Application\PHPStan;

use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Type;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpMethodReflection;

class InvokableMethodReflection implements MethodReflection
{
    /** @var  PhpMethodReflection */
    private $name;
    private $defaultMethodReflection;
    private $returnType;

    public function __construct(
        $name,
        $returnType,
        $defaultMethodReflection
    ) {
        $this->name = $name;
        $this->returnType = $returnType;
        $this->defaultMethodReflection = $defaultMethodReflection;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->defaultMethodReflection->getDeclaringClass();
    }

    public function getPrototype(): MethodReflection
    {
        return $this->defaultMethodReflection->getPrototype();
    }

    public function isStatic(): bool
    {
        return $this->defaultMethodReflection->isStatic();
    }

    public function isPrivate(): bool
    {
        return $this->defaultMethodReflection->isPrivate();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isPublic(): bool
    {
        return $this->defaultMethodReflection->isPublic();
    }

    /**
     * @return \PHPStan\Reflection\ParameterReflection[]
     */
    public function getParameters(): array
    {
        return $this->defaultMethodReflection->getParameters();
    }

    public function isVariadic(): bool
    {
        return $this->defaultMethodReflection->isVariadic();
    }

    public function getReturnType(): Type
    {
        return $this->returnType;
    }
}
