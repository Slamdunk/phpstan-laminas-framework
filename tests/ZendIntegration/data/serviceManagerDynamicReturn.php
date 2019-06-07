<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\ServiceManager\ServiceLocatorInterface;

final class serviceManagerDynamicReturn
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceManager;

    public function __construct(ServiceLocatorInterface $serviceManager)
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

    public function nonObjectServices(): void
    {
        $config = $this->serviceManager->get('my_config');
        $var    = $config['foo'];
        $var    = $config['xyz'];
        $var    = $config->foo;
    }
}
