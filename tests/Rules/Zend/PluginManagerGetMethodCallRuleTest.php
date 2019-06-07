<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Rules\Zend;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use ZendPhpStan\Rules\Zend\ServiceManagerGetMethodCallRule;
use ZendPhpStan\Type\Zend\ServiceManagerGetDynamicReturnTypeExtension;
use ZendPhpStan\ServiceManagerLoader;

/**
 * @covers \ZendPhpStan\Rules\Zend\ServiceManagerGetMethodCallRule
 */
final class PluginManagerGetMethodCallRuleTest extends RuleTestCase
{
    /**
     * @var ServiceManagerLoader
     */
    private $serviceManagerLoader;

    protected function setUp()
    {
        $this->serviceManagerLoader = new ServiceManagerLoader(null);
    }

    protected function getRule(): Rule
    {
        return new ServiceManagerGetMethodCallRule($this->createBroker(), $this->serviceManagerLoader);
    }

    public function testRule(): void
    {
        $this->analyse([__DIR__ . '/PluginManagerGetMethodCallRule/Foo.php'], [
            [
                'The service "non_existent_service" was not configured in ControllerPluginManager nor the class "non_existent_service" exists.',
                25,
            ],
        ]);
    }

    /**
     * @return \PHPStan\Type\DynamicMethodReturnTypeExtension[]
     */
    public function getDynamicMethodReturnTypeExtensions(): array
    {
        return [
            new ServiceManagerGetDynamicReturnTypeExtension($this->serviceManagerLoader),
        ];
    }
}
