<?php

namespace LaminasPhpStan\TestAsset;

final class HeavyService
{
    public function __construct()
    {
        throw new \RuntimeException('Too heavy to load for Static Analysis');
    }

    public function foo(): bool
    {
        return true;
    }
}