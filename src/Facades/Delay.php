<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Facades;

use Illuminate\Support\Facades\Facade;
use Newman\LaravelDelay\Contracts\DelayContract;

/**
 * @mixin DelayContract
 */
class Delay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DelayContract::class;
    }
}
