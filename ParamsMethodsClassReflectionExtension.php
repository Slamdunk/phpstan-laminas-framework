<?php


namespace Application\PHPStan;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareClassReflectionExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

use PHPStan\Type\ObjectType;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\ServiceManager;

class ParamsMethodsClassReflectionExtension implements
    MethodsClassReflectionExtension,
    BrokerAwareClassReflectionExtension
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
        $pluginManager = new PluginManager(new ServiceManager());
        echo $methodName;
        $methodIsPlugin = $pluginManager->has($methodName);
        if ($methodIsPlugin) {
            echo " is a plugin";
        }
        echo PHP_EOL;
        return ($methodIsPlugin);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $pluginManager = new PluginManager(new ServiceManager());
        $plugin = $pluginManager->get($methodName);

        $pluginName = $methodName;
        $pluginClassName = get_class($plugin);

        $methodIsInvokable = is_callable($pluginManager->get($methodName));
        if ($methodIsInvokable) {
            $methodReflection = $this->broker->getClass(get_class($plugin))->getMethod('__invoke');
            $returnType = $methodReflection->getReturnType();
            return new ParamsMethodReflection(
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
