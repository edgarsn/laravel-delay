<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Tests\Support;

use Newman\LaravelDelay\Traits\Delayable;

class ClassWithDelayableTrait
{
    use Delayable;
}
