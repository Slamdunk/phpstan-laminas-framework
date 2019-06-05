<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;

final class ServiceManagerGetDynamicReturnTypeExtension implements BrokerAwareExtension, DynamicMethodReturnTypeExtension
{
    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    /**
     * @var Broker
     */
    private $broker;

    public function __construct(ServiceManagerLoader $serviceManagerLoader)
    {
        $this->serviceManagerLoader = $serviceManagerLoader;
    }

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function getClass(): string
    {
        return ServiceLocatorInterface::class;
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

        if (1 !== \count($methodCall->args)) {
            return new MixedType();
        }

        $serviceManager = $this->serviceManagerLoader->getServiceManager($calledOnType->getClassName());

        $argType = $scope->getType($methodCall->args[0]->value);
        if (! $argType instanceof ConstantStringType) {
            if ($serviceManager instanceof AbstractPluginManager) {
                $refClass    = new \ReflectionClass($serviceManager);
                $refProperty = $refClass->getProperty('instanceOf');
                $refProperty->setAccessible(true);
                $returnedInstance = $refProperty->getValue($serviceManager);
                if (null !== $returnedInstance && $this->broker->hasClass($returnedInstance)) {
                    return new ObjectType($returnedInstance);
                }
            }

            return new MixedType();
        }

        $serviceName = $argType->getValue();
        if (! $serviceManager->has($serviceName)) {
            return new NeverType();
        }

        $serviceClass = \get_class($serviceManager->get($serviceName));

        return new ObjectServiceManagerType($serviceClass, $serviceName);
    }
}
