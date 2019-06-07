<?php

declare(strict_types=1);

use PHPStan\Testing\LevelsTestCase;

/**
 * @coversNothing
 */
final class IntegrationTest extends LevelsTestCase
{
    public function dataTopics(): array
    {
        return [
            ['serviceManagerDynamicReturn'],
            ['controllerRequestResponseDynamicReturn'],
            ['controllerPluginMethod'],
            ['controllerMethod'],
            ['routePluginMethod'],
            ['viewHelperPluginMethod'],
            ['stdlibArrayObjectCrate'],
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
