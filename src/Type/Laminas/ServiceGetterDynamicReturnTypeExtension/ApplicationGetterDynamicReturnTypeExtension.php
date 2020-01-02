<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\Mvc\ApplicationInterface;

final class ApplicationGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ApplicationInterface::class;
    }
}
