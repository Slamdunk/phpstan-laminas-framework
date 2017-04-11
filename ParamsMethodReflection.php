<?php

namespace Application\PHPStan;

use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Type;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\Php\PhpMethodReflection;


class ParamsMethodReflection implements MethodReflection
{
    /** @var  PhpMethodReflection */
    private $defaultMethodReflection;

    public function __construct(PhpMethodReflection $defaultMethodReflection)
    {
        $this->defaultMethodReflection = $defaultMethodReflection;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->defaultMethodReflection->getDeclaringClass();
    }

    public function getPrototype(): MethodReflection  // originally : self, but ParamsMethodReflection
        //                                            // is not the same as MethodReflection apparently
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

    public function isPublic(): bool
    {
        return $this->defaultMethodReflection->isPublic();
    }

    public function getName(): string
    {
        return 'params';  // lowercase because that's the way it's invoked?  ok to be hardcoded?
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
        return $this->defaultMethodReflection->getReturnType();
    }

}
