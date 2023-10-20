<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\Router\RouteInterface;
use Laminas\Router\RoutePluginManager;
use Laminas\ServiceManager\ServiceManager;
use LaminasPhpStan\TestAsset\Route66;

final class routePluginMethod
{
    /** @var RoutePluginManager<Route66> */
    private RoutePluginManager $routePluginManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->routePluginManager = $serviceManager->get('RoutePluginManager');
    }

    public function getDynamicType(RouteInterface $route): void
    {
        $this->routePluginManager->get('route66');
        $this->routePluginManager->get('foobar123');

        $var = \uniqid();
        $this->routePluginManager->get($var)->foobar456();
        $this->routePluginManager->get($var)->assemble([], []);
    }
}
