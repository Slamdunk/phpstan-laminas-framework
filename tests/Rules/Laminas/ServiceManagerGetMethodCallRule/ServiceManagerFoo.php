<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas\ServiceManagerGetMethodCallRule;

use Laminas\Form\FormElementManager;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\ServiceManager;
use stdClass;

final class ServiceManagerFoo
{
    private ServiceManager $serviceManager;

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
        $this->serviceManager->get(FormElementManager::class);
    }

    public function get(string $foo): void
    {
    }
}
