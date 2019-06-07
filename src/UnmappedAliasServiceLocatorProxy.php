<?php

declare(strict_types=1);

namespace ZendPhpStan;

use PHPStan\ShouldNotHappenException;
use Zend\Cache\PatternPluginManager;
use Zend\Cache\PatternPluginManager\PatternPluginManagerV3Polyfill;
use Zend\Form\FormElementManager\FormElementManagerV3Polyfill;
use Zend\Log\FilterPluginManager as LogFilterPluginManager;
use Zend\Log\FormatterPluginManager as LogFormatterPluginManager;
use Zend\Log\ProcessorPluginManager as LogProcessorPluginManager;
use Zend\Log\WriterPluginManager as LogWriterPluginManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

final class UnmappedAliasServiceLocatorProxy implements ServiceLocatorInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @var array
     */
    private $knownUnmappedAliasToClassServices = [
        ControllerManager::class                => 'ControllerManager',
        FormElementManagerV3Polyfill::class     => 'FormElementManager',
        HelperPluginManager::class              => 'ViewHelperManager',
        LogFilterPluginManager::class           => 'LogFilterManager',
        LogFormatterPluginManager::class        => 'LogFormatterManager',
        LogProcessorPluginManager::class        => 'LogProcessorManager',
        LogWriterPluginManager::class           => 'LogWriterManager',
        PatternPluginManagerV3Polyfill::class   => PatternPluginManager::class,

        // As string to not autoload them in static analysis, otherwise we would get
        // a PHP Warning:  Declaration of [...] should be compatible with [...] error
        '\Zend\Form\FormElementManager\FormElementManager' . 'V2Polyfill'       => 'FormElementManager',
        '\Zend\Cache\PatternPluginManager\PatternPluginManager' . 'V2Polyfill'  => PatternPluginManager::class,
    ];

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function get($id)
    {
        return $this->serviceLocator->get($this->knownUnmappedAliasToClassServices[$id] ?? $id);
    }

    public function has($id)
    {
        return $this->serviceLocator->has($this->knownUnmappedAliasToClassServices[$id] ?? $id);
    }

    public function build($name, array $options = null)
    {
        throw new ShouldNotHappenException(\sprintf('Why did you call %s?', __METHOD__));
    }
}
