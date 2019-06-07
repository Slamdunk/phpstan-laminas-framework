<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Mail\Transport\Envelope;
use Zend\Stdlib\AbstractOptions;

final class stdlibAbstractOptionsProperties
{
    public function mainLibrary()
    {
        $envelope = new Envelope();

        // Bad
        $envelope->foobar = 1;
        $envelope->from   = new \stdClass();

        // Good
        $envelope->from = 'test@example.com';
    }

    public function custom()
    {
        $class = new class() extends AbstractOptions {
            public function getMyxyz($var): string
            {
            }
        };

        // Bad
        $class->myxyz = 123;

        // Good
        \var_dump($class->myxyz);
    }

    public function notAbstractOptionsImplementation()
    {
        $class = new class() {
            public function getMyxyz($var): string
            {
            }
        };

        // Bad
        $class->myxyz = 123;
        \var_dump($class->myxyz);
    }
}
