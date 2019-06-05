<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Rules\Zend\PluginManagerGetMethodCallRule;

use Zend\ServiceManager\ServiceManager;

final class Foo
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function foo()
    {
        $controllerPluginManager = $this->serviceManager->get('ControllerPluginManager');

        $controllerPluginManager->get('non_existent_service');
        $controllerPluginManager->get('redirect');
    }
}
