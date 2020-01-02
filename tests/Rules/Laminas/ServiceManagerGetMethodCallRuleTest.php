<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas;

use LaminasPhpStan\Rules\Laminas\ServiceManagerGetMethodCallRule;
use LaminasPhpStan\ServiceManagerLoader;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @covers \LaminasPhpStan\Rules\Laminas\ServiceManagerGetMethodCallRule
 * @covers \LaminasPhpStan\UnmappedAliasServiceLocatorProxy
 */
final class ServiceManagerGetMethodCallRuleTest extends RuleTestCase
{
    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    protected function setUp(): void
    {
        $this->serviceManagerLoader = new ServiceManagerLoader(null);
    }

    protected function getRule(): Rule
    {
        return new ServiceManagerGetMethodCallRule($this->createBroker(), $this->serviceManagerLoader);
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/ServiceManagerGetMethodCallRule/Foo.php'], [
            [
                'The service "non_existent_service" was not configured in Laminas\ServiceManager\ServiceManager.',
                27,
            ],
        ]);
    }
}
