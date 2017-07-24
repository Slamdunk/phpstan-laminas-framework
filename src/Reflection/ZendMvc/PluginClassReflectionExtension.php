<?php
namespace PHPStan\Reflection\ZendMvc;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareClassReflectionExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

use PHPStan\Type\ObjectType;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\ServiceManager;

use Zend\Mvc\Service;

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

class PluginClassReflectionExtension implements
    MethodsClassReflectionExtension,
    BrokerAwareClassReflectionExtension
{

    /* @var Broker */
    private $broker;
    private $pluginManager;

    public function __construct() {
        $this->initFramework();
    }

    /**
     * @param Broker $broker Class reflection broker
     * @return void
     */
    public function setBroker(Broker $broker)
    {
        $this->broker = $broker;
    }

    /**
     *  Initialise the ZF3 framework so that controller plugins defined in modules
     *  are found by the ControllerPluginManager.
     */
    public function initFramework()
    {
        // Cribbed right out of the Application class for ZF3
        $appConfig = require __DIR__ . '/../../../../config/application.config.php';
        if (file_exists(__DIR__ . '/../config/development.config.php')) {
            $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
        }
        $smConfig = isset($appConfig['service_manager']) ? $appConfig['service_manager'] : [];
        $smConfig = new Service\ServiceManagerConfig($smConfig);

        $serviceManager = new ServiceManager();
        $smConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $appConfig);

        $serviceManager->get('ModuleManager')->loadModules();

        $this->pluginManager = $serviceManager->get('ControllerPluginManager');

    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return $this->pluginManager->has($methodName);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $plugin = $this->pluginManager->get($methodName);

        $pluginName = $methodName;
        $pluginClassName = get_class($plugin);

        $methodIsInvokable = is_callable($this->pluginManager->get($methodName));

        if ($methodIsInvokable) {
            $methodReflection = $this->broker->getClass(get_class($plugin))->getMethod('__invoke');
            $returnType = $methodReflection->getReturnType();

            return new InvokableMethodReflection(
                $pluginName,
                $returnType,
                $methodReflection
            );
        } else {
            $returnType = new ObjectType($pluginClassName, true);

            return new PluginMethodReflection(
                $this->broker,
                $pluginName,
                $pluginClassName,
                $returnType
            );

        }
    }
}
