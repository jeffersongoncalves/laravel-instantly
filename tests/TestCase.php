<?php

namespace JeffersonGoncalves\Instantly\Tests;

use JeffersonGoncalves\Instantly\InstantlyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            InstantlyServiceProvider::class,
        ];
    }
}
