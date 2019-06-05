<?php

declare(strict_types=1);

use PHPStan\Testing\LevelsTestCase;

/**
 * @covers \ZendPhpStan\Type\Zend\ControllerPluginClassReflectionExtension
 * @covers \ZendPhpStan\Type\Zend\ObjectServiceManagerType
 * @covers \ZendPhpStan\Type\Zend\PluginMethodReflection
 * @covers \ZendPhpStan\Type\Zend\ServiceManagerGetDynamicReturnTypeExtension
 */
final class ServiceManagerIntegrationTest extends LevelsTestCase
{
    public function dataTopics(): array
    {
        return [
            ['serviceManagerDynamicReturn'],
            ['controllerPluginMethod'],
            ['controllerMethod'],
            ['routePluginMethod'],
            ['viewHelperPluginMethod'],
        ];
    }

    public function getDataPath(): string
    {
        return __DIR__ . '/data';
    }

    public function getPhpStanExecutablePath(): string
    {
        return __DIR__ . '/../../vendor/bin/phpstan';
    }

    public function getPhpStanConfigPath(): ?string
    {
        return __DIR__ . '/phpstan.neon';
    }
}
