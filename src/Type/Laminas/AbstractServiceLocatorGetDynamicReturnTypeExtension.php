<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Laminas\ServiceManager\AbstractPluginManager;
use LaminasPhpStan\ServiceManagerLoader;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Constant\ConstantStringType;
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
    ) {
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return 'get' === $methodReflection->getName();
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $calledOnType = $scope->getType($methodCall->var);
        if (! $calledOnType instanceof ObjectType) {
            return new MixedType();
        }

        $args = $methodCall->getArgs();
        if (1 !== \count($args)) {
            return new MixedType();
        }

        $serviceManager = $this->serviceManagerLoader->getServiceLocator($calledOnType->getClassName());

        $firstArg = $args[0];
        if (! $firstArg instanceof Arg) {
            throw new \PHPStan\ShouldNotHappenException(\sprintf(
                'Argument passed to %s::%s should be a string, %s given',
                $methodReflection->getDeclaringClass()->getName(),
                $methodReflection->getName(),
                $firstArg->getType()
            ));
        }
        $argType = $scope->getType($firstArg->value);
        if (! $argType instanceof ConstantStringType) {
            if ($serviceManager instanceof AbstractPluginManager) {
                $refClass    = new ReflectionClass($serviceManager);
                $refProperty = $refClass->getProperty('instanceOf');
                $refProperty->setAccessible(true);
                $returnedInstance = $refProperty->getValue($serviceManager);
                \assert(null === $returnedInstance || \is_string($returnedInstance));
                if (null !== $returnedInstance && $this->reflectionProvider->hasClass($returnedInstance)) {
                    return new ObjectType($returnedInstance);
                }
            }

            return new MixedType();
        }

        $serviceName = $argType->getValue();
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
