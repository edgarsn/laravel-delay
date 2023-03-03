<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Tests;

use Newman\LaravelDelay\DelayFake;
use Newman\LaravelDelay\Facades\Delay;

class FacadeTest extends TestCase
{
    public function test_it_sleeps_through_facade(): void
    {
        /** @var DelayFake $facade */
        $facade = Delay::for(3);

        $facade->assertSleep()->assertSleepFor(3);
    }
}
