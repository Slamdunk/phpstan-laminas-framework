<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Router\RouteInterface;
use Zend\Router\RoutePluginManager;
use Zend\ServiceManager\ServiceManager;

final class routePluginMethod
{
    /**
     * @var RoutePluginManager
     */
    private $routePluginManager;

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
