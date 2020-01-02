<?php

namespace LaminasPhpStan\TestAsset;

use Laminas\Router\RouteInterface;
use Laminas\Router\RouteMatch;
use Laminas\Stdlib\DispatchableInterface;
use Laminas\Stdlib\RequestInterface;
use Laminas\Stdlib\Response;
use Laminas\Stdlib\ResponseInterface;

final class Route66 implements RouteInterface
{
    public function isRoute66(): bool
    {
        return true;
    }

    /**
     * Create a new route with given options.
     *
     * @param array|\Traversable $options
     * @return RouteInterface
     */
    public static function factory($options = [])
    {
        return new self();
    }

    /**
     * Match a given request.
     *
     * @param RequestInterface $request
     * @return RouteMatch|null
     */
    public function match(RequestInterface $request)
    {
        // TODO: Implement match() method.
    }

    /**
     * Assemble the route.
     *
     * @param array $params
     * @param array $options
     * @return mixed
     */
    public function assemble(array $params = [], array $options = [])
    {
        // TODO: Implement assemble() method.
    }
}