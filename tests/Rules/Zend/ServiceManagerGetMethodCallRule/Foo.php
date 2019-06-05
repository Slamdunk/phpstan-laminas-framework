<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Rules\Zend\ServiceManagerGetMethodCallRule;

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
    }
}
