<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\Mail\Transport\Envelope;
use Laminas\Stdlib\AbstractOptions;
use stdClass;

final class stdlibAbstractOptionsProperties
{
    public function mainLibrary(): void
    {
        $envelope = new Envelope();

        // Bad
        $envelope->foobar = 1;
        $envelope->from   = new stdClass();

        // Good
        $envelope->from = 'test@example.com';
    }

    public function custom(): void
    {
        $class = new class() extends AbstractOptions {
            /**
             * @var string
             */
            private $myxyz = 'foo';

            public function getMyxyz(string $var): string
            {
                return $var;
            }
        };

        // Bad
        $class->myxyz = 123;

        // Good
        \var_dump($class->myxyz);
    }

    public function notAbstractOptionsImplementation(): void
    {
        $class = new class() {
            public function getMyxyz(string $var): string
            {
                return $var;
            }
        };

        // Bad
        $class->myxyz = 123;
        \var_dump($class->myxyz);
    }
}
