<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Rules\Zend\ServiceManagerGetMethodCallRule;

use Zend\Cache\PatternPluginManager\PatternPluginManagerV3Polyfill;
use Zend\Form\FormElementManager\FormElementManagerV3Polyfill;
use Zend\Mvc\Controller\ControllerManager;
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
        $this->serviceManager->get('non_existent_service');

        $this->serviceManager->get('EventManager');
        $this->serviceManager->get('foo', 'bar');
        $this->serviceManager->get([]);

        $getterName = 'get';
        $this->serviceManager->{$getterName}('EventManager');
        $this->serviceManager->has('EventManager');

        $stdClass = new \stdClass();
        $stdClass->get('non_existent_service');

        $this->serviceManager->get(ControllerManager::class);
        $this->serviceManager->get(FormElementManagerV3Polyfill::class);
        $this->serviceManager->get('\Zend\Form\FormElementManager\FormElementManagerV2Polyfill');
        $this->serviceManager->get(PatternPluginManagerV3Polyfill::class);
        $this->serviceManager->get('\Zend\Cache\PatternPluginManager\PatternPluginManagerV2Polyfill');
    }

    public function get(string $foo)
    {
    }
}
