<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Tests;

use Newman\LaravelDelay\Contracts\DelayContract;
use Newman\LaravelDelay\DelayFake;
use Newman\LaravelDelay\DelayServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
	parent::setUp();

	$this->app->bind(DelayContract::class, DelayFake::class);
    }

    protected function getPackageProviders($app): array
    {
	return [
	    DelayServiceProvider::class,
	];
    }
}
