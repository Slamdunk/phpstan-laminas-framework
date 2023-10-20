<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\ServiceManager\ServiceLocatorInterface;
use LaminasPhpStan\TestAsset\FooInterface;
use LaminasPhpStan\TestAsset\FooService;
use LaminasPhpStan\TestAsset\HeavyService;

final class serviceManagerDynamicReturn
{
    private ServiceLocatorInterface $serviceManager;

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

        $heavyService = $this->serviceManager->get(HeavyService::class);
        $heavyService->foo();
        $heavyService->bar();
    }

    public function nonObjectServices(): void
    {
        $config = $this->serviceManager->get('my_config');
        $var    = $config['foo'];
        $var    = $config['xyz'];
        $var    = $config->foo;
    }

    public function testAnonymousClassWithParent(): void
    {
        $fooProxy = $this->serviceManager->get('foo_proxy');
        (static function (FooService $fooService): void {})($fooProxy);

        $fooImpl = $this->serviceManager->get('foo_impl');
        (static function (FooInterface $fooService): void {})($fooImpl);
    }
}
