<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Laminas\Mvc\Controller\AbstractController;
use Laminas\ServiceManager\ServiceLocatorInterface;
use LaminasPhpStan\ServiceManagerLoader;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;

final class ControllerPluginClassReflectionExtension implements MethodsClassReflectionExtension
{
    public function __construct(
        private ReflectionProvider $reflectionProvider,
        private ServiceManagerLoader $serviceManagerLoader
    ) {}

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return
            $this->reflectionProvider->hasClass(AbstractController::class)
            && $classReflection->isSubclassOfClass($this->reflectionProvider->getClass(AbstractController::class))
            && $this->getControllerPluginManager()->has($methodName);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $plugin = $this->getControllerPluginManager()->get($methodName);
        \assert(\is_object($plugin));

        $pluginClassName = $plugin::class;

        if (\is_callable($plugin)) {
            return $this->reflectionProvider->getClass($pluginClassName)->getNativeMethod('__invoke');
        }

        $returnType = new ObjectType($pluginClassName);

        return new PluginMethodReflection(
            $classReflection,
            $methodName,
            $returnType
        );
    }

    private function getControllerPluginManager(): ServiceLocatorInterface
    {
        return $this->serviceManagerLoader->getServiceLocator('ControllerPluginManager');
    }
}
