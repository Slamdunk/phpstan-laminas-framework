<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\PluginMethodDynamicReturnTypeExtension;

use LaminasPhpStan\ServiceManagerLoader;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\VerbosityLevel;

abstract class AbstractPluginMethodDynamicReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    private ServiceManagerLoader $serviceManagerLoader;

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
        $argType = $scope->getType($methodCall->args[0]->value);
        $strings = TypeUtils::getConstantStrings($argType);
        $plugin  = 1 === \count($strings) ? $strings[0]->getValue() : null;

        if (null !== $plugin) {
            $pluginManager = $this->serviceManagerLoader->getServiceLocator($this->getPluginManagerName());

            return new ObjectType(\get_class($pluginManager->get($plugin)));
        }

        if ($argType instanceof StringType) {
            return ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $methodReflection->getVariants())->getReturnType();
        }

        throw new \PHPStan\ShouldNotHappenException(\sprintf(
            'Argument passed to %s::%s should be a string, %s given',
            $methodReflection->getDeclaringClass()->getName(),
            $methodReflection->getName(),
            $argType->describe(VerbosityLevel::value())
        ));
    }

    abstract protected function getPluginManagerName(): string;
}
