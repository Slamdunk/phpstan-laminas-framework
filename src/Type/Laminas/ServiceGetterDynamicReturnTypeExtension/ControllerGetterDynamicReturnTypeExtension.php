<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas\ServiceGetterDynamicReturnTypeExtension;

use Laminas\Mvc\Controller\AbstractController;

final class ControllerGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return AbstractController::class;
    }
}
