<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\Mvc\Controller\AbstractActionController;

final class controllerPluginMethod extends AbstractActionController
{
    public function getDynamicType(): void
    {
        $this->bar()->isBar();

        $this->bar()->isFoo();
        $this->foo()->isFoo();
    }
}
