<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Zend\View\View;

final class ViewDynamicReturnTypeExtension extends AbstractServiceDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return View::class;
    }
}
