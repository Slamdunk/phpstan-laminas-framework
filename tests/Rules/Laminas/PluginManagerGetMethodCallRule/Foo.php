<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas\PluginManagerGetMethodCallRule;

use Laminas\ServiceManager\ServiceManager;

final class Foo
{
    private ServiceManager $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function foo(): void
    {
        $controllerPluginManager = $this->serviceManager->get('ControllerPluginManager');

        $controllerPluginManager->get('non_existent_service');
        $controllerPluginManager->get('redirect');
    }
}
