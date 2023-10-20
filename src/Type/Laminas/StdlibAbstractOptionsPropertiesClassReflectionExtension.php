<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Laminas\Stdlib\AbstractOptions;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertiesClassReflectionExtension;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\Type\Type;

final class StdlibAbstractOptionsPropertiesClassReflectionExtension implements PropertiesClassReflectionExtension
{
    public function hasProperty(ClassReflection $classReflection, string $propertyName): bool
    {
        return $classReflection->isSubclassOf(AbstractOptions::class) && $classReflection->hasNativeMethod($this->getGetterName($propertyName));
    }

    public function getProperty(ClassReflection $classReflection, string $propertyName): PropertyReflection
    {
        return new class($classReflection, $propertyName, $this->getSetterName($propertyName)) implements PropertyReflection {
            public function __construct(
                private ClassReflection $classReflection,
                private string $propertyName,
                private string $setterName
            ) {}

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
                return $this->getReadableType();
            }

            public function isReadable(): bool
            {
                return true;
            }

            public function isWritable(): bool
            {
                return $this->classReflection->hasNativeMethod($this->setterName);
            }

            public function getDocComment(): ?string
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->getDocComment();
            }

            public function getReadableType(): Type
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->getReadableType();
            }

            public function getWritableType(): Type
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->getWritableType();
            }

            public function canChangeTypeAfterAssignment(): bool
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->canChangeTypeAfterAssignment();
            }

            public function isDeprecated(): \PHPStan\TrinaryLogic
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->isDeprecated();
            }

            public function getDeprecatedDescription(): ?string
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->getDeprecatedDescription();
            }

            public function isInternal(): \PHPStan\TrinaryLogic
            {
                return $this->classReflection->getNativeProperty($this->propertyName)->isInternal();
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
