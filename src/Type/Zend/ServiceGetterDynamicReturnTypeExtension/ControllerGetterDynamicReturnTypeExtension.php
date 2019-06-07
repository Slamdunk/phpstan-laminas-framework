<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend\ServiceGetterDynamicReturnTypeExtension;

use Zend\Mvc\Controller\AbstractController;

final class ControllerGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return AbstractController::class;
    }
}
