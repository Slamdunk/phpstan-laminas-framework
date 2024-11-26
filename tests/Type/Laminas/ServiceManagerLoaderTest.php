<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Type\Laminas;

use Laminas\Mvc\Controller\PluginManager as ControllerPluginManager;
use Laminas\ServiceManager\ServiceManager;
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
        $serviceManagerLoader   = new ServiceManagerLoader(\dirname(__DIR__, 2) . '/LaminasIntegration/servicemanagerloader.php');

        $serviceManager = $serviceManagerLoader->getServiceLocator(ServiceManager::class);

        self::assertTrue($serviceManager->has('foo'));
        self::assertFalse($serviceManager->has('bar'));

        self::assertInstanceOf(FooService::class, $serviceManager->get('foo'));

        $controllerPluginManager = $serviceManager->get('ControllerPluginManager');

        self::assertInstanceOf(ControllerPluginManager::class, $controllerPluginManager);
        self::assertFalse($controllerPluginManager->has('foo'));
        self::assertTrue($controllerPluginManager->has('bar'));

        self::assertInstanceOf(BarService::class, $controllerPluginManager->get('bar'));
    }
}
