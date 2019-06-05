<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

final class viewHelperPluginMethod
{
    /**
     * @var HelperPluginManager
     */
    private $viewHelperManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->viewHelperManager = $serviceManager->get('ViewHelperManager');
    }

    public function getDynamicType(): void
    {
        $this->viewHelperManager->get('css');
        $this->viewHelperManager->get('foobar');
    }
}
