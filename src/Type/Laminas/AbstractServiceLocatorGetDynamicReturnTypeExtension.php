<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Laminas\ServiceManager\AbstractPluginManager;
use LaminasPhpStan\ServiceManagerLoader;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use ReflectionClass;

abstract class AbstractServiceLocatorGetDynamicReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function __construct(
        private ReflectionProvider $reflectionProvider,
        private ServiceManagerLoader $serviceManagerLoader
    ) {}

    final public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return 'get' === $methodReflection->getName();
    }

    final public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $calledOnType = $scope->getType($methodCall->var);
        if (! $calledOnType->isObject()->yes()) {
            return new MixedType();
        }

        $args = $methodCall->getArgs();
        if (1 !== \count($args)) {
            return new MixedType();
        }

        $serviceManager = $this->serviceManagerLoader->getServiceLocator($calledOnType->getObjectClassNames()[0]);

        $firstArg            = $args[0];
        $argType             = $scope->getType($firstArg->value);
        $constantStringTypes = $argType->getConstantStrings();
        if (1 !== \count($constantStringTypes)) {
            if ($serviceManager instanceof AbstractPluginManager) {
                $refClass         = new ReflectionClass($serviceManager);
                $refProperty      = $refClass->getProperty('instanceOf');
                $returnedInstance = $refProperty->getValue($serviceManager);
                \assert(null === $returnedInstance || \is_string($returnedInstance));
                if (null !== $returnedInstance && $this->reflectionProvider->hasClass($returnedInstance)) {
                    return new ObjectType($returnedInstance);
                }
            }

            return new MixedType();
        }

        $serviceName = $constantStringTypes[0]->getValue();
        if (! $serviceManager->has($serviceName)) {
            return new NeverType();
        }

        if (\class_exists($serviceName) || \interface_exists($serviceName)) {
            return new ObjectServiceManagerType($serviceName, $serviceName);
        }

        $service = $serviceManager->get($serviceName);
        if (\is_object($service)) {
            $className = $service::class;
            $refClass  = new ReflectionClass($service);
            if ($refClass->isAnonymous()) {
                if (false !== ($parentClass = $refClass->getParentClass())) {
                    $className = $parentClass->getName();
                } elseif ([] !== ($interfaces = $refClass->getInterfaces())) {
                    $className = \current($interfaces)->getName();
                }
            }

            return new ObjectServiceManagerType($className, $serviceName);
        }

        return $scope->getTypeFromValue($service);
    }
}
