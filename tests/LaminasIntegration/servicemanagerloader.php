<?php

declare(strict_types=1);

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;
use LaminasPhpStan\TestAsset\BarService;
use LaminasPhpStan\TestAsset\CssService;
use LaminasPhpStan\TestAsset\FooService;
use LaminasPhpStan\TestAsset\Route66;
use LaminasPhpStan\TestAsset\XyzController;

$serviceManagerConfig = new ServiceManagerConfig();
$serviceManager       = new ServiceManager();
$serviceManagerConfig->configureServiceManager($serviceManager);
$serviceManager->setService('ApplicationConfig', [
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
$serviceManager->get(ModuleManager::class)->loadModules();

return $serviceManager;
