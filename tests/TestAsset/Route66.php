<?php

namespace ZendPhpStan\TestAsset;

use Zend\Router\RouteInterface;
use Zend\Router\RouteMatch;
use Zend\Stdlib\DispatchableInterface;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\Response;
use Zend\Stdlib\ResponseInterface;

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