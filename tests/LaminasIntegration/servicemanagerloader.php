<?php

declare(strict_types=1);

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use LaminasPhpStan\TestAsset\BarService;
use LaminasPhpStan\TestAsset\CssService;
use LaminasPhpStan\TestAsset\FooService;
use LaminasPhpStan\TestAsset\HeavyService;
use LaminasPhpStan\TestAsset\Route66;
use LaminasPhpStan\TestAsset\XyzController;

$app = \Laminas\Mvc\Application::init([
    'modules' => [
        'Laminas\Router',
        'LaminasPhpStan' => new class() implements ConfigProviderInterface {
            /**
             * @return array<string, array<string, array<string, array<string, string>|string>>>
             */
            public function getConfig()
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
