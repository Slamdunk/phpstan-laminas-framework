<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\ServiceLocatorInterface;

final class ControllerRequestResponseDynamicReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    private $methodToServiceMap = [
        'getRequest'    => 'Request',
        'getResponse'   => 'Response',
    ];

    public function __construct(ServiceManagerLoader $serviceManagerLoader)
    {
        $this->serviceManagerLoader = $serviceManagerLoader;
    }

    public function getClass(): string
    {
        return AbstractController::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return isset($this->methodToServiceMap[$methodReflection->getName()]);
    }

    public function getTypeFromMethodCall(
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
