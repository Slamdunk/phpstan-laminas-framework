<?php

declare(strict_types=1);

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use ZendPhpStan\TestAsset\BarService;
use ZendPhpStan\TestAsset\CssService;
use ZendPhpStan\TestAsset\FooService;
use ZendPhpStan\TestAsset\Route66;
use ZendPhpStan\TestAsset\XyzController;

$serviceManagerConfig = new ServiceManagerConfig();
$serviceManager       = new ServiceManager();
$serviceManagerConfig->configureServiceManager($serviceManager);
$serviceManager->setService('ApplicationConfig', [
    'modules' => [
        'Zend\Router',
        'zendphpstan' => new class() implements ConfigProviderInterface {
            /**
             * @return array|\Traversable
             */
            public function getConfig()
            {
                return [
                    'service_manager' => [
                        'invokables' => [
                            'foo' => FooService::class,
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
