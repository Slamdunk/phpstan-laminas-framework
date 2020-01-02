<?php


namespace LaminasPhpStan\TestAsset;

use Laminas\View\Helper\HelperInterface;
use Laminas\View\Renderer\RendererInterface as Renderer;

final class CustomViewHelperPlugin implements HelperInterface
{
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