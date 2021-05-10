<?php

declare(strict_types=1);

namespace LaminasPhpStan\Type\Laminas;

use PHPStan\Type\ObjectType;

final class ObjectServiceManagerType extends ObjectType
{
    private string $serviceName;

    public function __construct(string $className, string $serviceName)
    {
        parent::__construct($className);
        $this->serviceName = $serviceName;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }
}
