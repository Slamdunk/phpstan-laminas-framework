<?php

declare(strict_types=1);

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\Application;
use Laminas\ServiceManager\Factory\InvokableFactory;
use LaminasPhpStan\TestAsset\BarService;
use LaminasPhpStan\TestAsset\CssService;
use LaminasPhpStan\TestAsset\FooInterface;
use LaminasPhpStan\TestAsset\FooService;
use LaminasPhpStan\TestAsset\HeavyService;
use LaminasPhpStan\TestAsset\Route66;
use LaminasPhpStan\TestAsset\XyzController;

$app = Application::init([
    'modules' => [
        'Laminas\Router',
        'LaminasPhpStan' => new class implements ConfigProviderInterface {
            /** @return array<string, array<string, array<string, array<string, string>|Closure|string>>> */
            public function getConfig(): array
            {
                return [
                    'service_manager' => [
                        'invokables' => [
                            'foo' => FooService::class,
                        ],
                        'services' => [
                            'my_config' => [
                                'foo' => 'bar',
                            ],
                        ],
                        'factories' => [
                            HeavyService::class => InvokableFactory::class,
                            'foo_proxy'         => static function (): FooService {
                                return new class extends FooService {};
                            },
                            'foo_impl'         => static function (): FooInterface {
                                return new class implements FooInterface {
                                    public function isFoo(): bool
                                    {
                                        return true;
                                    }
                                };
                            },
                        ],
                    ],
                    'controllers' => [
                        'invokables' => [
                            'xyz' => XyzController::class,
                        ],
                    ],
                    'controller_plugins' => [
                        'invokables' => [
                            'bar' => BarService::class,
                        ],
                    ],
                    'route_manager' => [
                        'invokables' => [
                            'route66' => Route66::class,
                        ],
                    ],
                    'view_helpers' => [
                        'invokables' => [
                            'css' => CssService::class,
                        ],
                    ],
                ];
            }
        },
    ],
    'module_listener_options' => [],
]);

return $app->getServiceManager();
