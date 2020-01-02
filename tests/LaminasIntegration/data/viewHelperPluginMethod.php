<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\ServiceManager\ServiceManager;
use Laminas\View\HelperPluginManager;
use LaminasPhpStan\TestAsset\CustomViewHelperPlugin;

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
