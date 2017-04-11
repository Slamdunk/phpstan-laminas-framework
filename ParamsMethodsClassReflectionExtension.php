<?php


namespace Application\PHPStan;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareClassReflectionExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use Zend\Mvc\Controller\Plugin\Params;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\ServiceManager;

class ParamsMethodsClassReflectionExtension implements
    MethodsClassReflectionExtension, BrokerAwareClassReflectionExtension
{

    /* @var Broker */
    private $broker;

    /**
     * @param Broker $broker Class reflection broker
     * @return void
     */
    public function setBroker(Broker $broker)
    {
        $this->broker = $broker;
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        //return ($methodName === 'params');
        $parentContainer = new NullServiceManager();
        $pluginManager = new PluginManager($parentContainer, []);
        echo $methodName . PHP_EOL;
        return ($pluginManager->has($methodName) && is_callable($pluginManager->get($methodName)));
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $parentContainer = new NullServiceManager();
        $pluginManager = new PluginManager($parentContainer, []);
        $plugin = $pluginManager->get($methodName);
        $pluginName = ucfirst($methodName);
        $nativeReflection = $classReflection->getNativeReflection();
        return new ParamsMethodReflection(
            $pluginName,
            $this->broker->getClass(get_class($plugin))->getMethod('__invoke')
        );
    }

}