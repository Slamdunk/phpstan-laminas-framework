<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;

final class controllerMethod
{
    /**
     * @var ControllerManager
     */
    private $controllerManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->controllerManager = $serviceManager->get('ControllerManager');
    }

    public function getDynamicType(): void
    {
        $this->controllerManager->get('xyz');
        $this->controllerManager->get('foobar');
    }
}
