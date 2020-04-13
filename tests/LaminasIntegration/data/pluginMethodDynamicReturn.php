<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\Router\SimpleRouteStack;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Helper\AbstractHelper;

final class pluginMethodDynamicReturn
{
    /**
     * @var PhpRenderer
     */
    private $phpRenderer;

    public function getDynamicTypeFromStaticString(): void
    {
        $urlHelper = $this->phpRenderer->plugin('url');
        $urlHelper->setRouter(new SimpleRouteStack());
        $urlHelper->foobar();
    }

    public function callGetDynamicTypeFromVariable(): void
    {
        $urlHelper = $this->getDynamicTypeFromStringVariable('url');
        $urlHelper->foobar();
    }

    public function getDynamicTypeFromStringVariable(string $name): AbstractHelper
    {
        return $this->phpRenderer->plugin($name);
    }

}
