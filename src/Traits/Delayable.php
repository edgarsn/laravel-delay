<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Traits;

use Newman\LaravelDelay\Contracts\DelayContract;

trait Delayable
{
    /**
     * Initiate a new delay.
     *
     * @param int|null $seconds
     * @return DelayContract
     */
    public function delay(?int $seconds = null): DelayContract
    {
	/** @var DelayContract $delay */
	$delay = app()->make(DelayContract::class);

	if ($seconds !== null) {
	    $delay->for($seconds);
	}

	return $delay;
    }
}
