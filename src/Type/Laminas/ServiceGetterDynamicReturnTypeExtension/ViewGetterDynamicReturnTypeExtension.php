<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\View\View;

final class ViewGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return View::class;
    }
}
