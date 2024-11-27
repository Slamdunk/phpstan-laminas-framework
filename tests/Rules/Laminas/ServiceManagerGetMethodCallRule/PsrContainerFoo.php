<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas\ServiceManagerGetMethodCallRule;

use Laminas\Mvc\Controller\ControllerManager;
use Psr\Container\ContainerInterface;
use stdClass;

final class PsrContainerFoo
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function foo(): void
    {
        $this->container->get('non_existent_service');

        $this->container->get('EventManager');
        $this->container->get('foo', 'bar');
        $this->container->get([]);

        $getterName = 'get';
        $this->container->{$getterName}('EventManager');
        $this->container->has('EventManager');

        $stdClass = new stdClass();
        $stdClass->get('non_existent_service');

        $this->container->get(ControllerManager::class);
    }

    public function get(string $foo): void {}
}
