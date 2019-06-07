<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\Rules\Zend;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use ZendPhpStan\Rules\Zend\ServiceManagerGetMethodCallRule;
use ZendPhpStan\Type\Zend\ServiceManagerLoader;

/**
 * @covers \ZendPhpStan\Rules\Zend\ServiceManagerGetMethodCallRule
 * @covers \ZendPhpStan\UnmappedAliasServiceLocatorProxy
 */
final class ServiceManagerGetMethodCallRuleTest extends RuleTestCase
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
        $this->analyse([__DIR__ . '/ServiceManagerGetMethodCallRule/Foo.php'], [
            [
                'The service "non_existent_service" was not configured in Zend\ServiceManager\ServiceManager.',
                26,
            ],
        ]);
    }
}
