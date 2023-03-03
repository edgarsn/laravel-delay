<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Tests;

use Carbon\Carbon;
use Newman\LaravelDelay\Contracts\DelayContract;

class DelayTest extends TestCase
{
    public function test_it_sleeps_for_given_time(): void
    {
        $this->app->make(DelayContract::class)->for(5)->assertSleep()->assertSleepFor(5);
        $this->app->make(DelayContract::class)->forMs(135)->assertSleep()->assertSleepForMiliseconds(135);
        $this->app->make(DelayContract::class)->forMiliseconds(135)->assertSleep()->assertSleepForMiliseconds(135);
        $this->app->make(DelayContract::class)->forMicroseconds(5432)->assertSleep()->assertSleepForMicroseconds(5432);

        Carbon::setTestNow(Carbon::create(2022, 3, 1, 12, 00, 00, 'UTC'));
        $this->app->make(DelayContract::class)->till(Carbon::now()->addSeconds(10))->assertSleep()->assertSleepFor(10);
        Carbon::setTestNow(null);
    }

    public function test_it_sleeps_on_given_environments_only(): void
    {
        $this->app->make(DelayContract::class)->for(5)->environments(['production', 'staging'])->fakeEnvironment('staging')->assertSleep();
        $this->app->make(DelayContract::class)->for(5)->environments(['production', 'staging'])->fakeEnvironment('development')->assertNotSleep();
    }

    public function test_it_sleeps_with_exceptions(): void
    {
        // excepted environments
        $this->app->make(DelayContract::class)->for(5)->except(['production'])->fakeEnvironment('staging')->assertSleep();
        $this->app->make(DelayContract::class)->for(5)->except(['staging'])->fakeEnvironment('staging')->assertNotSleep();

        // exception callbacks
        $this->app->make(DelayContract::class)->for(5)->exceptWhen(fn() => false)->assertSleep();
        $this->app->make(DelayContract::class)->for(5)->exceptWhen(fn() => true)->assertNotSleep();

        $this->app->make(DelayContract::class)->for(5)->exceptWhen(fn() => false)->exceptWhen(fn() => false)->assertSleep();
        $this->app->make(DelayContract::class)->for(5)->exceptWhen(fn() => false)->exceptWhen(fn() => true)->assertNotSleep();
    }

    public function test_real_world_usage_samples(): void
    {
        $this->app->make(DelayContract::class)
            ->for(5)
            ->environments(['production', 'staging'])
            ->except(['development'])
            ->exceptWhen(fn() => false)
            ->fakeEnvironment('production')
            ->assertSleep();
    }
}
