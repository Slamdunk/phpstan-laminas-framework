<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Zend\Mvc\MvcEvent;

final class MvcEventDynamicReturnTypeExtension extends AbstractServiceDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return MvcEvent::class;
    }
}
