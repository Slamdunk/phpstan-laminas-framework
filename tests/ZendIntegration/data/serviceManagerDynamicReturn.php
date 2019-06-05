<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\ServiceManager\ServiceManager;

final class serviceManagerDynamicReturn
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getDynamicType(): void
    {
        $fooService = $this->serviceManager->get('foo');
        $fooService->isFoo();

        $barService = $this->serviceManager->get('bar');
        $barService->isBar();

        $viewHelperManager = $this->serviceManager->get('ViewHelperManager');

        $viewHelperManager->get('css')->isCss();
        $viewHelperManager->get('css')->isCssWut();

        $viewHelperManager->get('foobar')->isCss();
    }
}
