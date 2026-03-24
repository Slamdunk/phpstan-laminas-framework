<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\Rules\Laminas;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Laminas\ServiceManager\ServiceManager;
use LaminasPhpStan\Rules\Laminas\ServiceManagerGetMethodCallRule;
use LaminasPhpStan\ServiceManagerLoader;
use LaminasPhpStan\UnmappedAliasServiceLocatorProxy;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * @extends RuleTestCase<ServiceManagerGetMethodCallRule>
 */
#[CoversClass(ServiceManagerGetMethodCallRule::class)]
#[CoversClass(UnmappedAliasServiceLocatorProxy::class)]
final class ServiceManagerGetMethodCallRuleTest extends RuleTestCase
{
    private ServiceManagerLoader $serviceManagerLoader;

    protected function setUp(): void
    {
        $this->serviceManagerLoader = new ServiceManagerLoader(\dirname(__DIR__, 2) . '/LaminasIntegration/servicemanagerloader.php');
    }

    /** @return Rule<MethodCall> */
    protected function getRule(): Rule
    {
        return new ServiceManagerGetMethodCallRule($this->createReflectionProvider(), $this->serviceManagerLoader);
    }

    #[DataProvider('provideRuleCases')]
    public function testRule(string $filename, string $containerClassname): void
    {
        $this->analyse([__DIR__ . '/ServiceManagerGetMethodCallRule/' . $filename], [
            [
                'The service "non_existent_service" was not configured in ' . $containerClassname . '.',
                22,
            ],
        ]);
    }

    /** @return string[][] */
    public static function provideRuleCases(): iterable
    {
        return [
            'ServiceManager'    => ['ServiceManagerFoo.php', ServiceManager::class],
            'Interop container' => ['InteropContainerFoo.php', InteropContainerInterface::class],
            'PSR container'     => ['PsrContainerFoo.php', PsrContainerInterface::class],
        ];
    }
}
