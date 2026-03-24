<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration;

use PHPStan\Testing\LevelsTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversNothing]
final class IntegrationTest extends LevelsTestCase
{
    #[DataProvider('dataTopics')]
    public function testLevels(string $topic): void
    {
        parent::testLevels($topic);
    }

    public static function dataTopics(): array
    {
        return [
            ['serviceManagerDynamicReturn'],
            ['controllerRequestResponseDynamicReturn'],
            ['controllerPluginMethod'],
            ['controllerMethod'],
            ['routePluginMethod'],
            ['viewHelperPluginMethod'],
            ['stdlibArrayObjectCrate'],
            ['stdlibAbstractOptionsProperties'],
            ['pluginMethodDynamicReturn'],
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

    public function getPhpStanConfigPath(): string
    {
        return __DIR__ . '/phpstan.neon';
    }
}
