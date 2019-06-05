<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Zend\Mvc\Controller\AbstractController;

final class ControllerDynamicReturnTypeExtension extends AbstractServiceDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return AbstractController::class;
    }
}
