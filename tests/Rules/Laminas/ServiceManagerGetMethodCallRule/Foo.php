<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas\ServiceManagerGetMethodCallRule;

use Laminas\Cache\PatternPluginManager\PatternPluginManagerV3Polyfill;
use Laminas\Form\FormElementManager\FormElementManagerV3Polyfill;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\ServiceManager;
use stdClass;

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

    public function foo(): void
    {
        $this->serviceManager->get('non_existent_service');

        $this->serviceManager->get('EventManager');
        $this->serviceManager->get('foo', 'bar');
        $this->serviceManager->get([]);

        $getterName = 'get';
        $this->serviceManager->{$getterName}('EventManager');
        $this->serviceManager->has('EventManager');

        $stdClass = new stdClass();
        $stdClass->get('non_existent_service');

        $this->serviceManager->get(ControllerManager::class);
        $this->serviceManager->get(FormElementManagerV3Polyfill::class);
        $this->serviceManager->get('\Laminas\Form\FormElementManager\FormElementManagerV2Polyfill');
        $this->serviceManager->get(PatternPluginManagerV3Polyfill::class);
        $this->serviceManager->get('\Laminas\Cache\PatternPluginManager\PatternPluginManagerV2Polyfill');
    }

    public function get(string $foo): void
    {
    }
}
