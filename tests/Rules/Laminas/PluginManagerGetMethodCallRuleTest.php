<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas;

use LaminasPhpStan\Rules\Laminas\ServiceManagerGetMethodCallRule;
use LaminasPhpStan\ServiceManagerLoader;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @covers \LaminasPhpStan\Rules\Laminas\ServiceManagerGetMethodCallRule
 *
 * @extends RuleTestCase<ServiceManagerGetMethodCallRule>
 */
final class PluginManagerGetMethodCallRuleTest extends RuleTestCase
{
    private ServiceManagerLoader $serviceManagerLoader;

    protected function setUp(): void
    {
        $this->serviceManagerLoader = new ServiceManagerLoader(null);
    }

    /** @return Rule<\PhpParser\Node\Expr\MethodCall> */
    protected function getRule(): Rule
    {
        return new ServiceManagerGetMethodCallRule($this->createReflectionProvider(), $this->serviceManagerLoader);
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/PluginManagerGetMethodCallRule/Foo.php'], [
            [
                'The service "non_existent_service" was not configured in ControllerPluginManager nor the class "non_existent_service" exists.',
                22,
            ],
        ]);
    }

    /** @return string[] */
    public static function getAdditionalConfigFiles(): array
    {
        return [
            __DIR__ . '/../../../extension.neon',
        ];
    }
}
