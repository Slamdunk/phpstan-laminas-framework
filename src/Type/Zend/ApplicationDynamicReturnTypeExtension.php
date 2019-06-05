<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Zend\Mvc\ApplicationInterface;

final class ApplicationDynamicReturnTypeExtension extends AbstractServiceDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ApplicationInterface::class;
    }
}
