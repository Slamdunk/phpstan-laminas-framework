<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\PluginMethodDynamicReturnTypeExtension;

use Laminas\Validator\ValidatorChain;
use Laminas\Validator\ValidatorPluginManager;

final class ValidatorChainPluginMethodDynamicReturnTypeExtension extends AbstractPluginMethodDynamicReturnTypeExtension
{
    protected function getPluginManagerName(): string
    {
        return ValidatorPluginManager::class;
    }

    public function getClass(): string
    {
        return ValidatorChain::class;
    }
}
