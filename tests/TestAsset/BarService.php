<?php

namespace ZendPhpStan\TestAsset;

use Zend\Mvc\Controller\Plugin\PluginInterface;
use Zend\Stdlib\DispatchableInterface as Dispatchable;

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
    public function setController(Dispatchable $controller)
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