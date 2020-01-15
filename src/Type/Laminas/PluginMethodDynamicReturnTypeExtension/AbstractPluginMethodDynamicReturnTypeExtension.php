<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\PluginMethodDynamicReturnTypeExtension;

use LaminasPhpStan\ServiceManagerLoader;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;

abstract class AbstractPluginMethodDynamicReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    final public function __construct(ServiceManagerLoader $serviceManagerLoader)
    {
        $this->serviceManagerLoader = $serviceManagerLoader;
    }

    final public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return 'plugin' === $methodReflection->getName();
    }

    final public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $pluginManager = $this->serviceManagerLoader->getServiceLocator($this->getPluginManagerName());
        $argType       = $scope->getType($methodCall->args[0]->value);
        if (! $argType instanceof ConstantStringType) {
            throw new \PHPStan\ShouldNotHappenException(\sprintf('Argument passed to %s::%s should be a string, %s given',
                $methodReflection->getDeclaringClass()->getName(),
                $methodReflection->getName(),
                $argType->describe(VerbosityLevel::value())
            ));
        }
        $pluginClass   = \get_class($pluginManager->get($argType->getValue()));

        return new ObjectType($pluginClass);
    }

    abstract protected function getPluginManagerName(): string;
}
