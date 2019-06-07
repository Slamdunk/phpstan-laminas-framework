<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;
use ZendPhpStan\TestAsset\CustomViewHelperPlugin;

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
        $this->viewHelperManager->get('foobar');
        $this->viewHelperManager->get('css');
        $this->viewHelperManager->get(CustomViewHelperPlugin::class);
    }
}
