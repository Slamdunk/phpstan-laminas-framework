<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use Laminas\ServiceManager\ServiceLocatorInterface;

final class ServiceManagerGetDynamicReturnTypeExtension extends AbstractServiceLocatorGetDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ServiceLocatorInterface::class;
    }
}
