<?php

declare(strict_types = 1);

namespace Newman\LaravelDelay;

use \Illuminate\Support\ServiceProvider;
use Newman\LaravelDelay\Contracts\DelayContract;

class DelayServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
	$this->app->bind(DelayContract::class, Delay::class);
    }
}
