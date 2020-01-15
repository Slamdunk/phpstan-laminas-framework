<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\Router\SimpleRouteStack;
use Laminas\View\Renderer\PhpRenderer;

final class pluginMethodDynamicReturn
{
    /**
     * @var PhpRenderer
     */
    private $phpRenderer;

    public function getDynamicType(): void
    {
        $urlHelper = $this->phpRenderer->plugin('url');
        $urlHelper->setRouter(new SimpleRouteStack());
        $urlHelper->foobar();
    }
}
