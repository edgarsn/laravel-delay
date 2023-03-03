<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Tests;

use Newman\LaravelDelay\DelayFake;
use Newman\LaravelDelay\Tests\Support\ClassWithDelayableTrait;

class DelayableTraitTest extends TestCase
{
    public function test_it_returns_implemented_class(): void
    {
        $classWithTrait = new ClassWithDelayableTrait();

        $this->assertInstanceOf(DelayFake::class, $classWithTrait->delay());
    }

    public function test_it_returns_implemented_class_with_seconds(): void
    {
        $classWithTrait = new ClassWithDelayableTrait();

        $classWithTrait->delay(5)->assertSleepFor(5);
    }
}
