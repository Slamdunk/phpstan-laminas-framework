<?php

declare(strict_types=1);

namespace LaminasPhpStan;

use Laminas\Log\FilterPluginManager as LogFilterPluginManager;
use Laminas\Log\FormatterPluginManager as LogFormatterPluginManager;
use Laminas\Log\ProcessorPluginManager as LogProcessorPluginManager;
use Laminas\Log\WriterPluginManager as LogWriterPluginManager;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\View\HelperPluginManager;
use PHPStan\ShouldNotHappenException;

final class UnmappedAliasServiceLocatorProxy implements ServiceLocatorInterface
{
    private ServiceLocatorInterface $serviceLocator;

    /**
     * @var array<string, string>
     */
    private array $knownUnmappedAliasToClassServices = [
        ControllerManager::class                => 'ControllerManager',
        HelperPluginManager::class              => 'ViewHelperManager',
        LogFilterPluginManager::class           => 'LogFilterManager',
        LogFormatterPluginManager::class        => 'LogFormatterManager',
        LogProcessorPluginManager::class        => 'LogProcessorManager',
        LogWriterPluginManager::class           => 'LogWriterManager',
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

    /**
     * @param string            $name
     * @param null|array<mixed> $options
     *
     * @throws ShouldNotHappenException
     *
     * @return mixed|void
     */
    public function build($name, ?array $options = null)
    {
        throw new ShouldNotHappenException(\sprintf('Why did you call %s?', __METHOD__));
    }
}
