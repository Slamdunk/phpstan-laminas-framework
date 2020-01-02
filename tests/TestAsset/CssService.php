<?php

namespace LaminasPhpStan\TestAsset;

use Laminas\View\Helper\HelperInterface;
use Laminas\View\Renderer\RendererInterface as Renderer;

final class CssService implements HelperInterface
{
    public function isCss(): bool
    {
        return true;
    }

    /**
     * Set the View object
     *
     * @param Renderer $view
     * @return HelperInterface
     */
    public function setView(Renderer $view)
    {
        // TODO: Implement setView() method.
    }

    /**
     * Get the View object
     *
     * @return Renderer
     */
    public function getView()
    {
        // TODO: Implement getView() method.
    }
}