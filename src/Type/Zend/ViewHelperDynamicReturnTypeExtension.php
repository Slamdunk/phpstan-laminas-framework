<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\RendererInterface;

final class ViewHelperDynamicReturnTypeExtension extends AbstractServiceDynamicReturnTypeExtension
{
    /**
     * @var array
     */
    protected $methodToServiceMap = [
        'getView' => RendererInterface::class,
    ];

    public function getClass(): string
    {
        return AbstractHelper::class;
    }
}
