<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\View\Renderer\RendererInterface;
use LaminasPhpStan\ServiceManagerLoader;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

abstract class AbstractServiceGetterDynamicReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    private ServiceManagerLoader $serviceManagerLoader;

    /** @var array<string, string> */
    protected array $methodToServiceMap = [
        'getApplication'    => 'Application',
        'getRenderer'       => RendererInterface::class,
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
        $serviceManager  = $this->serviceManagerLoader->getServiceLocator(ServiceLocatorInterface::class);
        $serviceName     = $this->methodToServiceMap[$methodReflection->getName()];
        $serviceInstance = $serviceManager->get($serviceName);
        \assert(\is_object($serviceInstance));
        $serviceClass   = $serviceInstance::class;

        return new ObjectType($serviceClass);
    }
}
