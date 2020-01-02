<?php

declare(strict_types=1);

namespace LaminasPhpStan;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface as PsrContainerInterface;

final class ServiceManagerLoader
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var string[]
     */
    private $knownModules = [
        \Laminas\Cache\Module::class,
        \Laminas\Filter\Module::class,
        \Laminas\Form\Module::class,
        \Laminas\Hydrator\Module::class,
        \Laminas\I18n\Module::class,
        \Laminas\InputFilter\Module::class,
        \Laminas\Log\Module::class,
        \Laminas\Mail\Module::class,
        \Laminas\Paginator\Module::class,
        \Laminas\Router\Module::class,
        \Laminas\Validator\Module::class,
    ];

    /**
     * @var array<string, true>
     */
    private $serviceManagerNames = [
        ServiceManager::class            => true,
        ServiceLocatorInterface::class   => true,
        InteropContainerInterface::class => true,
        PsrContainerInterface::class     => true,
    ];

    public function __construct(?string $serviceManagerLoader)
    {
        if (null === $serviceManagerLoader) {
            return;
        }

        if (! \file_exists($serviceManagerLoader) || ! \is_readable($serviceManagerLoader)) {
            throw new \PHPStan\ShouldNotHappenException('Service manager could not be loaded');
        }

        $serviceManager = require $serviceManagerLoader;
        if (! $serviceManager instanceof ServiceManager) {
            throw new \PHPStan\ShouldNotHappenException(\sprintf('Loader "%s" doesn\'t return a ServiceManager instance', $serviceManagerLoader));
        }

        $this->setServiceLocator($serviceManager);
    }

    private function setServiceLocator(ServiceLocatorInterface $serviceLocator): void
    {
        $this->serviceLocator = new UnmappedAliasServiceLocatorProxy($serviceLocator);
    }

    public function getServiceLocator(string $serviceManagerName): ServiceLocatorInterface
    {
        if (null === $this->serviceLocator) {
            $serviceManagerConfig = new ServiceManagerConfig();
            $serviceManager       = new ServiceManager();
            $serviceManagerConfig->configureServiceManager($serviceManager);
            $config = [
                'modules'                 => [],
                'module_listener_options' => [],
            ];
            foreach ($this->knownModules as $module) {
                if (\class_exists($module)) {
                    $config['modules'][$module] = new $module();
                }
            }
            $serviceManager->setService('ApplicationConfig', $config);
            $serviceManager->get(ModuleManager::class)->loadModules();

            $this->setServiceLocator($serviceManager);
        }

        $serviceLocator = $this->serviceLocator;
        if (! isset($this->serviceManagerNames[$serviceManagerName])) {
            $serviceLocator = $serviceLocator->get($serviceManagerName);
        }

        return $serviceLocator;
    }
}
