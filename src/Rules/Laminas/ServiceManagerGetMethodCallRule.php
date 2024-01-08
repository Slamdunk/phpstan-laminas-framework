<?php

declare(strict_types=1);

namespace LaminasPhpStan\Rules\Laminas;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\ServiceLocatorInterface;
use LaminasPhpStan\ServiceManagerLoader;
use LaminasPhpStan\Type\Laminas\ObjectServiceManagerType;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use ReflectionClass;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
final class ServiceManagerGetMethodCallRule implements Rule
{
    public function __construct(
        private ReflectionProvider $reflectionProvider,
        private ServiceManagerLoader $serviceManagerLoader
    ) {}

    public function getNodeType(): string
    {
        return Node\Expr\MethodCall::class;
    }

    /**
     * @param MethodCall $node
     *
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $args = $node->getArgs();
        if (1 !== \count($args)) {
            return [];
        }

        $firstArg = $args[0];
        if (! $firstArg instanceof Arg) {
            return [];
        }
        $argType         = $scope->getType($firstArg->value);
        $constantStrings = $argType->getConstantStrings();
        if (1 !== \count($constantStrings)) {
            return [];
        }

        $calledOnType = $scope->getType($node->var);
        if (! $calledOnType->isObject()->yes() || ! $this->isTypeInstanceOfContainer($calledOnType)) {
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

        $serviceName    = $constantStrings[0]->getValue();
        $serviceManager = $this->serviceManagerLoader->getServiceLocator($calledOnType->getClassName());

        if ($serviceManager->has($serviceName)) {
            return [];
        }

        $classDoesNotExistNote = '';
        if ($serviceManager instanceof AbstractPluginManager) {
            $refClass              = new ReflectionClass($serviceManager);
            $refProperty           = $refClass->getProperty('autoAddInvokableClass');
            $autoAddInvokableClass = $refProperty->getValue($serviceManager);
            if ($autoAddInvokableClass) {
                if ($this->reflectionProvider->hasClass($serviceName)) {
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

    /** @phpstan-assert-if-true ObjectType $type */
    private function isTypeInstanceOfContainer(Type $type): bool
    {
        return (new ObjectType(ServiceLocatorInterface::class))->isSuperTypeOf($type)->yes()
            || (new ObjectType(InteropContainerInterface::class))->isSuperTypeOf($type)->yes()
            || (new ObjectType(PsrContainerInterface::class))->isSuperTypeOf($type)->yes();
    }
}
