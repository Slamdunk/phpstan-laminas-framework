<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractServiceDynamicReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    /**
     * @var array
     */
    private $methodToServiceMap = [
        'getApplication'    => 'Application',
        'getRequest'        => 'Request',
        'getResponse'       => 'Response',
    ];

    final public function __construct(ServiceManagerLoader $serviceManagerLoader)
    {
        $this->serviceManagerLoader = $serviceManagerLoader;
    }

    final public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return isset($this->methodToServiceMap[$methodReflection->getName()]);
    }

    final public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $serviceManager = $this->serviceManagerLoader->getServiceManager(ServiceLocatorInterface::class);
        $serviceName    = $this->methodToServiceMap[$methodReflection->getName()];
        $serviceClass   = \get_class($serviceManager->get($serviceName));

        return new ObjectType($serviceClass);
    }
}
