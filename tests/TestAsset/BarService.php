<?php

namespace LaminasPhpStan\TestAsset;

use Laminas\Mvc\Controller\Plugin\PluginInterface;
use Laminas\Stdlib\DispatchableInterface as Dispatchable;

final class BarService implements PluginInterface
{
    public function isBar(): bool
    {
        return true;
    }

    /**
     * Set the current controller instance
     *
     * @param Dispatchable $controller
     * @return void
     */
    public function setController(Dispatchable $controller): void
    {
        // TODO: Implement setController() method.
    }

    /**
     * Get the current controller instance
     *
     * @return null|Dispatchable
     */
    public function getController()
    {
        // TODO: Implement getController() method.
    }
}