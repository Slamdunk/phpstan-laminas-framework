<?php

namespace ZendPhpStan\TestAsset;

use Zend\Stdlib\DispatchableInterface;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\Response;
use Zend\Stdlib\ResponseInterface;

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