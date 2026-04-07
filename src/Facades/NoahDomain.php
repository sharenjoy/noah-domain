<?php

namespace Sharenjoy\NoahDomain\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sharenjoy\NoahDomain\NoahDomain
 */
class NoahDomain extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Sharenjoy\NoahDomain\NoahDomain::class;
    }
}
