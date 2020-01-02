<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\View\ViewEvent;

final class ViewEventGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ViewEvent::class;
    }
}
