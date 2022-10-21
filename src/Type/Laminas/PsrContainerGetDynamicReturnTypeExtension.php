<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Psr\Container\ContainerInterface;

final class PsrContainerGetDynamicReturnTypeExtension extends AbstractServiceLocatorGetDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ContainerInterface::class;
    }
}
