<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend\ServiceGetterDynamicReturnTypeExtension;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\RendererInterface;

final class ViewHelperGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
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
