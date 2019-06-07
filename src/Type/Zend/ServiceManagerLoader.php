<?php

declare(strict_types=1);

namespace ZendPhpStan\Type\Zend;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use ZendPhpStan\UnmappedAliasServiceLocatorProxy;

final class ServiceManagerLoader
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var array
     */
    private $knownModules = [
        \Zend\Cache\Module::class,
        \Zend\Filter\Module::class,
        \Zend\Form\Module::class,
        \Zend\Hydrator\Module::class,
        \Zend\I18n\Module::class,
        \Zend\InputFilter\Module::class,
        \Zend\Log\Module::class,
        \Zend\Mail\Module::class,
        \Zend\Paginator\Module::class,
        \Zend\Router\Module::class,
        \Zend\Validator\Module::class,
    ];

    /**
     * @var array
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
