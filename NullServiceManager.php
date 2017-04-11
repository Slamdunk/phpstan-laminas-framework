<?php

namespace Application\PHPStan;

use Zend\ServiceManager\ServiceLocatorInterface;

class NullServiceManager implements ServiceLocatorInterface
{
    public function get($id)
    {
        return null;
    }

    public function has($id)
    {
        return false;
    }

    public function build($name, array $options = null)
    {
        return null;
    }

}