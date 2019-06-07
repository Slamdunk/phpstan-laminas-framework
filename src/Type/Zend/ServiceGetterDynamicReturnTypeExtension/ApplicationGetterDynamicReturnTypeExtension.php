<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend\ServiceGetterDynamicReturnTypeExtension;

use Zend\Mvc\ApplicationInterface;

final class ApplicationGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ApplicationInterface::class;
    }
}
