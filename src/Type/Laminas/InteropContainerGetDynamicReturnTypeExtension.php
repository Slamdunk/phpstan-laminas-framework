<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Interop\Container\Containerinterface;

final class InteropContainerGetDynamicReturnTypeExtension extends AbstractServiceLocatorGetDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return Containerinterface::class;
    }
}
