<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\PluginMethodDynamicReturnTypeExtension;

use Laminas\Filter\FilterChain;
use Laminas\Filter\FilterPluginManager;

final class FilterChainPluginMethodDynamicReturnTypeExtension extends AbstractPluginMethodDynamicReturnTypeExtension
{
    protected function getPluginManagerName(): string
    {
        return FilterPluginManager::class;
    }

    public function getClass(): string
    {
        return FilterChain::class;
    }
}
