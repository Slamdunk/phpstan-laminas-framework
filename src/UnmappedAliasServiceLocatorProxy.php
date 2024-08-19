<?php

declare(strict_types=1);

namespace LaminasPhpStan;

use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\View\HelperPluginManager;
use PHPStan\ShouldNotHappenException;

final class UnmappedAliasServiceLocatorProxy implements ServiceLocatorInterface
{
    private ServiceLocatorInterface $serviceLocator;

    /** @var array<string, string> */
    private array $knownUnmappedAliasToClassServices = [
        ControllerManager::class                => 'ControllerManager',
        HelperPluginManager::class              => 'ViewHelperManager',
    ];

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function get($id)
    {
        if ($this->serviceLocator->has($id)) {
            return $this->serviceLocator->get($id);
        }

        return $this->serviceLocator->get($this->knownUnmappedAliasToClassServices[$id] ?? $id);
    }

    public function has($id): bool
    {
        return $this->serviceLocator->has($id)
            || $this->serviceLocator->has($this->knownUnmappedAliasToClassServices[$id] ?? $id);
    }

    /**
     * {@inheritDoc}
     *
     * @throws ShouldNotHappenException
     */
    public function build($name, ?array $options = null): mixed
    {
        throw new ShouldNotHappenException(\sprintf('Why did you call %s?', __METHOD__));
    }
}
