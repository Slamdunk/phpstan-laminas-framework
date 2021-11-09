<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Laminas\Mvc\Controller\AbstractController;
use Laminas\ServiceManager\ServiceLocatorInterface;
use LaminasPhpStan\ServiceManagerLoader;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Type\ObjectType;

final class ControllerPluginClassReflectionExtension implements BrokerAwareExtension, MethodsClassReflectionExtension
{
    private ServiceManagerLoader $serviceManagerLoader;

    private Broker $broker;

    public function __construct(ServiceManagerLoader $serviceManagerLoader)
    {
        $this->serviceManagerLoader = $serviceManagerLoader;
    }

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return $classReflection->isSubclassOf(AbstractController::class) && $this->getControllerPluginManager()->has($methodName);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $plugin = $this->getControllerPluginManager()->get($methodName);
        \assert(\is_object($plugin));

        $pluginClassName = \get_class($plugin);

        if (\is_callable($plugin)) {
            return $this->broker->getClass($pluginClassName)->getNativeMethod('__invoke');
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
