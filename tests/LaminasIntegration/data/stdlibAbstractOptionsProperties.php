<?php

declare(strict_types=1);

namespace LaminasPhpStan\Tests\LaminasIntegration\data;

use Laminas\ModuleManager\Listener\ListenerOptions;
use Laminas\Stdlib\AbstractOptions;
use stdClass;

final class stdlibAbstractOptionsProperties
{
    public function mainLibrary(): void
    {
        $envelope = new ListenerOptions();

        // Bad
        $envelope->foobar         = 1;
        $envelope->configCacheKey = new stdClass();

        // Good
        $envelope->configCacheKey = 'my_key';
    }

    public function custom(): void
    {
        $class                    = new class extends AbstractOptions {
            private string $myxyz = 'foo';

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
        $class = new class {
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
