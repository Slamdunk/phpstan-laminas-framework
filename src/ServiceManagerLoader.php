<?php

declare(strict_types=1);

namespace LaminasPhpStan;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Laminas\Mvc\Service\ServiceListenerFactory;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use ReflectionProperty;

final class ServiceManagerLoader
{
    private ?UnmappedAliasServiceLocatorProxy $serviceLocator = null;

    /** @var string[] */
    private array $knownModules = [
        \Laminas\Cache\ConfigProvider::class,
        \Laminas\Filter\ConfigProvider::class,
        \Laminas\Form\ConfigProvider::class,
        \Laminas\Hydrator\ConfigProvider::class,
        \Laminas\I18n\ConfigProvider::class,
        \Laminas\InputFilter\ConfigProvider::class,
        \Laminas\Mail\ConfigProvider::class,
        \Laminas\Paginator\ConfigProvider::class,
        \Laminas\Router\ConfigProvider::class,
        \Laminas\Validator\ConfigProvider::class,
    ];

    /** @var array<string, true> */
    private array $serviceManagerNames = [
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

        $this->serviceLocator = new UnmappedAliasServiceLocatorProxy($serviceManager);
    }

    public function getServiceLocator(string $serviceManagerName): ServiceLocatorInterface
    {
        if (null === $this->serviceLocator) {
            $serviceManager = new ServiceManager(['services' => ['config' => []]]);
            if (\class_exists(ServiceManagerConfig::class)) {
                (new ServiceManagerConfig())->configureServiceManager($serviceManager);
            }
            if (\class_exists(ServiceListenerFactory::class)) {
                $refProp = new ReflectionProperty(ServiceListenerFactory::class, 'defaultServiceConfig');
                $refProp->setAccessible(true);
                $config = $refProp->getValue(new ServiceListenerFactory());
                \assert(\is_array($config));
                \assert(\is_array($config['factories']));
                unset($config['factories']['config']);
                $refProp->setAccessible(false);
                $serviceManager->configure($config);
            }
            foreach ($this->knownModules as $module) {
                if (\class_exists($module)) {
                    $module = new $module();
                    \assert(\method_exists($module, 'getDependencyConfig'));
                    $serviceManager->configure($module->getDependencyConfig());
                }
            }

            $this->serviceLocator = new UnmappedAliasServiceLocatorProxy($serviceManager);
        }

        $serviceLocator = $this->serviceLocator;
        if (! isset($this->serviceManagerNames[$serviceManagerName])) {
            $serviceLocator = $serviceLocator->get($serviceManagerName);
            \assert($serviceLocator instanceof ServiceLocatorInterface);
        }

        return $serviceLocator;
    }
}
