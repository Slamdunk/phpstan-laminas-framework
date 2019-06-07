<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend\ServiceGetterDynamicReturnTypeExtension;

use Zend\View\View;

final class ViewGetterDynamicReturnTypeExtension extends AbstractServiceGetterDynamicReturnTypeExtension
{
    public function getClass(): string
    {
        return View::class;
    }
}
