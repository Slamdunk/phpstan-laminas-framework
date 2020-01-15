<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\PluginMethodDynamicReturnTypeExtension;

use Laminas\Mvc\Controller\AbstractController;
use Laminas\Mvc\Controller\PluginManager;

final class AbstractControllerPluginMethodDynamicReturnTypeExtension extends AbstractPluginMethodDynamicReturnTypeExtension
{
    protected function getPluginManagerName(): string
    {
        return PluginManager::class;
    }

    public function getClass(): string
    {
        return AbstractController::class;
    }
}
