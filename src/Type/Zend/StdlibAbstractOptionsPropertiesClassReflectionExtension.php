<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\Type;
use Zend\Stdlib\AbstractOptions;

final class StdlibAbstractOptionsPropertiesClassReflectionExtension implements PropertiesClassReflectionExtension
{
    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        return $classReflection->isSubclassOf(AbstractOptions::class) && $classReflection->hasNativeMethod($this->getGetterName($propertyName));
    }

    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        return new class($classReflection, $propertyName, $this->getGetterName($propertyName), $this->getSetterName($propertyName)) implements PropertyReflection {
            /**
             * @var ClassReflection
             */
            private $classReflection;
            /**
             * @var string
             */
            private $propertyName;
            /**
             * @var string
             */
            private $getterName;
            /**
             * @var string
             */
            private $setterName;

            public function __construct(ClassReflection $classReflection, string $propertyName, string $getterName, string $setterName)
            {
                $this->classReflection = $classReflection;
                $this->propertyName    = $propertyName;
                $this->getterName      = $getterName;
                $this->setterName      = $setterName;
            }

            public function getDeclaringClass(): ClassReflection
            {
                return $this->classReflection;
            }

            public function isStatic(): bool
            {
                return false;
            }

            public function isPrivate(): bool
            {
                return false;
            }

            public function isPublic(): bool
            {
                return true;
            }

            public function getType(): Type
            {
                $nativeGetter = $this->classReflection->getNativeMethod($this->getterName);

                return ParametersAcceptorSelector::selectSingle($nativeGetter->getVariants())->getReturnType();
            }

            public function isReadable(): bool
            {
                return true;
            }

            public function isWritable(): bool
            {
                return $this->classReflection->hasNativeMethod($this->setterName);
            }
        };
    }

    private function getGetterName(string $propertyName): string
    {
        return 'get' . \str_replace('_', '', $propertyName);
    }

    private function getSetterName(string $propertyName): string
    {
        return 'set' . \str_replace('_', '', $propertyName);
    }
}
