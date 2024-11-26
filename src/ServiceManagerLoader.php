<?php

declare(strict_types=1);

namespace LaminasPhpStan;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;
use PHPStan\ShouldNotHappenException;
use Psr\Container\ContainerInterface as PsrContainerInterface;

final readonly class ServiceManagerLoader
{
    private const serviceManagerNames = [
        ServiceManager::class            => true,
        ServiceLocatorInterface::class   => true,
        InteropContainerInterface::class => true,
        PsrContainerInterface::class     => true,
    ];

    private UnmappedAliasServiceLocatorProxy $serviceLocator;

    public function __construct(string $serviceManagerLoader)
    {
        if (! \file_exists($serviceManagerLoader) || ! \is_readable($serviceManagerLoader)) {
            throw new ShouldNotHappenException('Service manager could not be loaded');
        }

        $serviceManager = require $serviceManagerLoader;
        if (! $serviceManager instanceof ServiceManager) {
            throw new ShouldNotHappenException(\sprintf('Loader "%s" doesn\'t return a ServiceManager instance', $serviceManagerLoader));
        }

        $this->serviceLocator = new UnmappedAliasServiceLocatorProxy($serviceManager);
    }

    public function getServiceLocator(string $serviceManagerName): ServiceLocatorInterface
    {
        $serviceLocator = $this->serviceLocator;
        if (! isset(self::serviceManagerNames[$serviceManagerName])) {
            $serviceLocator = $serviceLocator->get($serviceManagerName);
            \assert($serviceLocator instanceof ServiceLocatorInterface);
        }

        return $serviceLocator;
    }
}
