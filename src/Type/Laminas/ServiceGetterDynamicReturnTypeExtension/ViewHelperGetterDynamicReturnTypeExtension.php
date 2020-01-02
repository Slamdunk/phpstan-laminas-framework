<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Renderer\RendererInterface;

final class ViewHelperGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    /**
     * @var array<string, string>
     */
    protected $methodToServiceMap = [
        'getView' => RendererInterface::class,
    ];

    public function getClass(): string
    {
        return AbstractHelper::class;
    }
}
