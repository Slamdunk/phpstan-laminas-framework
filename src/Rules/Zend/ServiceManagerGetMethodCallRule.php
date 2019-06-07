<?php

declare(strict_types=1);

namespace ZendPhpStan\Rules\Zend;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Rules\Rule;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ObjectType;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZendPhpStan\Type\Zend\ObjectServiceManagerType;
use ZendPhpStan\Type\Zend\ServiceManagerLoader;

final class ServiceManagerGetMethodCallRule implements Rule
{
    /**
     * @var Broker
     */
    private $broker;

    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    public function __construct(Broker $broker, ServiceManagerLoader $serviceManagerLoader)
    {
        $this->broker               = $broker;
        $this->serviceManagerLoader = $serviceManagerLoader;
    }

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    /**
     * @param \PhpParser\Node\Expr\MethodCall $node
     * @param Scope                           $scope
     *
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (1 !== \count($node->args)) {
            return [];
        }

        $argType = $scope->getType($node->args[0]->value);
        if (! $argType instanceof ConstantStringType) {
            return [];
        }

        $calledOnType = $scope->getType($node->var);
        if (! $calledOnType instanceof ObjectType || ! $calledOnType->isInstanceOf(ServiceLocatorInterface::class)->yes()) {
            return [];
        }

        $methodNameIdentifier = $node->name;
        if (! $methodNameIdentifier instanceof Node\Identifier) {
            return [];
        }

        $methodName = $methodNameIdentifier->toString();
        if ('get' !== $methodName) {
            return [];
        }

        $serviceName    = $argType->getValue();
        $serviceManager = $this->serviceManagerLoader->getServiceLocator($calledOnType->getClassName());

        if ($serviceManager->has($serviceName)) {
            return [];
        }

        $classDoesNotExistNote = '';
        if ($serviceManager instanceof AbstractPluginManager) {
            $refClass    = new \ReflectionClass($serviceManager);
            $refProperty = $refClass->getProperty('autoAddInvokableClass');
            $refProperty->setAccessible(true);
            $autoAddInvokableClass = $refProperty->getValue($serviceManager);
            if ($autoAddInvokableClass) {
                if ($this->broker->hasClass($serviceName)) {
                    return [];
                }
                $classDoesNotExistNote = \sprintf(' nor the class "%s" exists', $serviceName);
            }
        }

        return [\sprintf(
            'The service "%s" was not configured in %s%s.',
            $serviceName,
            $calledOnType instanceof ObjectServiceManagerType
                ? $calledOnType->getServiceName()
                : $calledOnType->getClassName(),
            $classDoesNotExistNote
        )];
    }
}
