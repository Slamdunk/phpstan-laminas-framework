<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\PluginMethodDynamicReturnTypeExtension;

use Laminas\View\HelperPluginManager;
use Laminas\View\Renderer\PhpRenderer;

final class PhpRendererPluginMethodDynamicReturnTypeExtension extends AbstractPluginMethodDynamicReturnTypeExtension
{
    protected function getPluginManagerName(): string
    {
        return HelperPluginManager::class;
    }

    public function getClass(): string
    {
        return PhpRenderer::class;
    }
}
