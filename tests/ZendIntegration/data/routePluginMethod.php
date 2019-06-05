<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

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

    public function getDynamicType(): void
    {
        $this->routePluginManager->get('route66');
        $this->routePluginManager->get('foobar');
    }
}
