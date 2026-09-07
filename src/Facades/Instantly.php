<?php

namespace JeffersonGoncalves\Instantly\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\Instantly\Instantly
 */
class Instantly extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Instantly\Instantly::class;
    }
}
