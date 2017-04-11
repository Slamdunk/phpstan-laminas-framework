<?php


namespace Application\PHPStan;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareClassReflectionExtension;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use Zend\Mvc\Controller\Plugin\Params;

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
        return ($methodName === 'params');
    }

	public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
       return new ParamsMethodReflection($this->broker->getClass(Params::class)->getMethod('__invoke'));
    }

}