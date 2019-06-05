<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Zend\View\ViewEvent;

final class ViewEventDynamicReturnTypeExtension extends AbstractServiceDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return ViewEvent::class;
    }
}
