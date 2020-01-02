<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\Mvc\MvcEvent;

final class MvcEventGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return MvcEvent::class;
    }
}
