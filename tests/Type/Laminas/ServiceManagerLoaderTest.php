<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Type\Laminas;

use Laminas\Cache\PatternPluginManager as CachePatternPluginManager;
use Laminas\Cache\Storage\AdapterPluginManager as CacheStorageAdapterPluginManager;
use Laminas\Cache\Storage\PluginManager as CacheStoragePluginManager;
use Laminas\Config\ReaderPluginManager as ConfigReaderPluginManager;
use Laminas\Config\WriterPluginManager as ConfigWriterPluginManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Filter\FilterPluginManager;
use Laminas\Form\FormElementManager;
use Laminas\Hydrator\HydratorPluginManager;
use Laminas\I18n\Translator\LoaderPluginManager as I18nLoaderPluginManager;
use Laminas\InputFilter\InputFilterPluginManager;
use Laminas\Log\FilterPluginManager as LogFilterPluginManager;
use Laminas\Log\FormatterPluginManager as LogFormatterPluginManager;
use Laminas\Log\ProcessorPluginManager as LogProcessorPluginManager;
use Laminas\Log\WriterPluginManager as LogWriterPluginManager;
use Laminas\Mail\Protocol\SmtpPluginManager;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\Mvc\Controller\PluginManager as ControllerPluginManager;
use Laminas\Paginator\AdapterPluginManager as PaginatorAdapterPluginManager;
use Laminas\Paginator\ScrollingStylePluginManager;
use Laminas\Router\RoutePluginManager;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Validator\ValidatorPluginManager;
use Laminas\View\Helper\Navigation\PluginManager as NavigationPluginManager;
use Laminas\View\HelperPluginManager;
use LaminasPhpStan\ServiceManagerLoader;
use LaminasPhpStan\TestAsset\BarService;
use LaminasPhpStan\TestAsset\FooService;
use PHPStan\ShouldNotHappenException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LaminasPhpStan\ServiceManagerLoader
 */
final class ServiceManagerLoaderTest extends TestCase
{
    public function testWithNullFileUseADefaultInstanceWithPluginManagerConfigured(): void
    {
        $serviceManagerLoader = new ServiceManagerLoader(null);

        $serviceManager = $serviceManagerLoader->getServiceLocator(ServiceManager::class);

        // @see \Laminas\Mvc\Service\ServiceManagerConfig
        self::assertTrue($serviceManager->has(EventManagerInterface::class));
        self::assertTrue($serviceManager->has('ControllerPluginManager'));

        /** @var ControllerPluginManager $controllerPluginManager */
        $controllerPluginManager = $serviceManager->get('ControllerPluginManager');

        self::assertTrue($controllerPluginManager->has('redirect'));
    }

    public function testGetSubserviceDependingOnCallOnTypeGiven(): void
    {
        $serviceManagerLoader = new ServiceManagerLoader(null);
        $knownPluginManagers  = [
            CachePatternPluginManager::class,
            CacheStorageAdapterPluginManager::class,
            CacheStoragePluginManager::class,
            // ConfigReaderPluginManager::class,
            // ConfigWriterPluginManager::class,
            ControllerManager::class,
            ControllerPluginManager::class,
            FilterPluginManager::class,
            FormElementManager::class,
            HelperPluginManager::class,
            HydratorPluginManager::class,
            I18nLoaderPluginManager::class,
            InputFilterPluginManager::class,
            LogFilterPluginManager::class,
            LogFormatterPluginManager::class,
            LogProcessorPluginManager::class,
            LogWriterPluginManager::class,
            // NavigationPluginManager::class,
            PaginatorAdapterPluginManager::class,
            RoutePluginManager::class,
            ScrollingStylePluginManager::class,
            SmtpPluginManager::class,
            ValidatorPluginManager::class,
        ];

        foreach ($knownPluginManagers as $pluginManagerClassName) {
            self::assertInstanceOf($pluginManagerClassName, $serviceManagerLoader->getServiceLocator($pluginManagerClassName));
        }
    }

    public function testLoaderMustBeAValidFile(): void
    {
        $this->expectException(ShouldNotHappenException::class);

        new ServiceManagerLoader(\uniqid(__DIR__ . '/woot'));
    }

    public function testLoaderMustReturnAServiceManagerInstance(): void
    {
        $this->expectException(ShouldNotHappenException::class);

        new ServiceManagerLoader(__DIR__ . '/data/nothingloader.php');
    }

    public function testLoaderReturnsTheProvidedServiceManager(): void
    {
        $file                   = \dirname(__DIR__, 2) . '/LaminasIntegration/servicemanagerloader.php';
        $serviceManagerFromFile = require $file;
        $serviceManagerLoader   = new ServiceManagerLoader($file);

        $serviceManager = $serviceManagerLoader->getServiceLocator(ServiceManager::class);

        self::assertTrue($serviceManager->has('foo'));
        self::assertFalse($serviceManager->has('bar'));

        self::assertInstanceOf(FooService::class, $serviceManager->get('foo'));

        $controllerPluginManager = $serviceManager->get('ControllerPluginManager');

        self::assertFalse($controllerPluginManager->has('foo'));
        self::assertTrue($controllerPluginManager->has('bar'));

        self::assertInstanceOf(BarService::class, $controllerPluginManager->get('bar'));
    }
}
