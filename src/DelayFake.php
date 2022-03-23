<?php

declare(strict_types = 1);

namespace Newman\LaravelDelay;

use Newman\LaravelDelay\Contracts\DelayContract;
use PHPUnit\Framework\Assert as PHPUnit;

class DelayFake extends DelayAbstract implements DelayContract
{
    /**
     * Faked environment.
     *
     * @var string
     */
    private string $fakeEnvironment;

    /**
     * Fake environment.
     *
     * @param string $environment
     * @return $this
     */
    public function fakeEnvironment(string $environment): static
    {
	$this->fakeEnvironment = $environment;

	return $this;
    }

    /**
     * Assert it went to sleep.
     *
     * @return static
     */
    public function assertSleep(): static
    {
	PHPUnit::assertTrue($this->_shouldSleep(), 'Expected to sleep, but it didn\'t');

	return $this;
    }

    /**
     * Assert it didn't go to sleep.
     *
     * @return static
     */
    public function assertNotSleep(): static
    {
	PHPUnit::assertFalse($this->_shouldSleep(), 'Expected not to sleep, but it did.');

	return $this;
    }

    /**
     * Assert it slept for given seconds.
     *
     * @param int $seconds
     * @return static
     */
    public function assertSleepFor(int $seconds): static
    {
	PHPUnit::assertTrue($seconds == $this->forSeconds, 'Expected to sleep for ' . $seconds . ' seconds, but actually slept for ' . $this->forSeconds . ' seconds.');

	return $this;
    }

    /**
     * Assert it slept for given miliseconds.
     *
     * @param int $miliseconds
     * @return static
     */
    public function assertSleepForMiliseconds(int $miliseconds): static
    {
	PHPUnit::assertTrue($miliseconds == $this->forMiliseconds, 'Expected to sleep for ' . $miliseconds . ' miliseconds, but actually slept for ' . $this->forMiliseconds . ' miliseconds.');

	return $this;
    }

    /**
     * Assert it slept for given microseconds.
     *
     * @param int $microseconds
     * @return static
     */
    public function assertSleepForMicroseconds(int $microseconds): static
    {
	PHPUnit::assertTrue($microseconds == $this->forMicroseconds, 'Expected to sleep for ' . $microseconds . ' microseconds, but actually slept for ' . $this->forMicroseconds . ' microseconds.');

	return $this;
    }

    /**
     * Get current environment.
     *
     * @return string
     */
    protected function getEnvironment(): string
    {
	return $this->fakeEnvironment ?? parent::getEnvironment();
    }

    /**
     * Go to sleep implementation.
     *
     * @return void
     */
    protected function goToSleep(): void
    {
    }
}
