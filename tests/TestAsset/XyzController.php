<?php

namespace LaminasPhpStan\TestAsset;

use Laminas\Stdlib\DispatchableInterface;
use Laminas\Stdlib\RequestInterface;
use Laminas\Stdlib\Response;
use Laminas\Stdlib\ResponseInterface;

final class XyzController implements DispatchableInterface
{
    public function isXyz(): bool
    {
        return true;
    }

    /**
     * Dispatch a request
     *
     * @param RequestInterface $request
     * @param null|ResponseInterface $response
     * @return Response|mixed
     */
    public function dispatch(RequestInterface $request, ResponseInterface $response = null)
    {
        // TODO: Implement dispatch() method.
    }
}