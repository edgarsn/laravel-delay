<?php

declare(strict_types=1);

namespace Newman\LaravelDelay;

use Newman\LaravelDelay\Contracts\DelayContract;

class Delay extends DelayAbstract implements DelayContract
{
    /**
     * Go to sleep implementation.
     *
     * @return void
     */
    protected function goToSleep(): void
    {
	if (!empty($this->forMicroseconds)) {
	    usleep($this->forMicroseconds);
	} else if (!empty($this->forMiliseconds)) {
	    usleep($this->forMiliseconds * 1000);
	} else if (!empty($this->forSeconds)) {
	    sleep($this->forSeconds);
	}
    }
}
