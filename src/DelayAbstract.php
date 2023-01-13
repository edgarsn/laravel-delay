<?php

declare(strict_types=1);

namespace Newman\LaravelDelay;

use Carbon\CarbonInterface;
use Closure;
use Illuminate\Contracts\Foundation\Application;

abstract class DelayAbstract
{

    /**
     * Delay for seconds.
     *
     * @var int
     */
    protected int $forSeconds;

    /**
     * Delay for miliseconds.
     *
     * @var int
     */
    protected int $forMiliseconds;

    /**
     * Delay for microseconds.
     *
     * @var int
     */
    protected int $forMicroseconds;

    /**
     * Delay only on theese environments.
     *
     * @var array<string>|null
     */
    protected ?array $environments = null;

    /**
     * Excepted environments.
     *
     * @var array<string>|null
     */
    protected ?array $exceptedEnvironments = null;

    /**
     * Excepted callbacks.
     *
     * @var array<Closure>
     */
    protected array $exceptCallbacks = [];

    /**
     * Construct delay object.
     *
     * @param Application $app
     */
    public function __construct(protected Application $app)
    {
    }

    /**
     * Delay for given seconds.
     *
     * @param int $seconds
     * @return $this
     */
    public function forSeconds(int $seconds): static
    {
	$this->forSeconds = $seconds;

	return $this;
    }

    /**
     * Delay for given miliseconds.
     *
     * @param int $miliseconds
     * @return $this
     */
    public function forMiliseconds(int $miliseconds): static
    {
	$this->forMiliseconds = $miliseconds;

	return $this;
    }

    /**
     * Delay for given microseconds.
     *
     * @param int $microseconds
     * @return $this
     */
    public function forMicroseconds(int $microseconds): static
    {
	$this->forMicroseconds = $microseconds;

	return $this;
    }

    /**
     * Delay for given seconds.
     *
     * @param int $seconds
     * @return $this
     */
    public function for(int $seconds): static
    {
	return $this->forSeconds($seconds);
    }

    /**
     * Delay for given miliseconds.
     *
     * @param int $miliseconds
     * @return $this
     */
    public function forMs(int $miliseconds): static
    {
	return $this->forMiliseconds($miliseconds);
    }

    /**
     * Delay till given datetime.
     *
     * @param CarbonInterface $carbon
     * @return $this
     */
    public function till(CarbonInterface $carbon): static
    {
	$this->forSeconds = $carbon->diffInSeconds();

	return $this;
    }

    /**
     * Delay only on given environments.
     *
     * @param array<string> $environments
     * @return $this
     */
    public function environments(array $environments): static
    {
	$this->environments = $environments;

	return $this;
    }

    /**
     * Delay excepting given environments.
     *
     * @param array<string> $environments
     * @return $this
     */
    public function except(array $environments): static
    {
	$this->exceptedEnvironments = $environments;

	return $this;
    }

    /**
     * Except when given Closure returns true.
     *
     * @param Closure $callback
     * @return $this
     */
    public function exceptWhen(Closure $callback): static
    {
	$this->exceptCallbacks[] = $callback;

	return $this;
    }

    /**
     * Get current environment.
     *
     * @codeCoverageIgnore
     * @return string
     */
    protected function getEnvironment(): string
    {
	return (string)$this->app->environment();
    }

    /**
     * Determines if item should go to sleep.
     *
     * @return bool
     */
    protected function _shouldSleep(): bool
    {
	$allowedEnvironments = $this->environments ?? [];

	if (!empty($this->exceptedEnvironments)) {
	    $allowedEnvironments = array_filter($allowedEnvironments, fn($env) => in_array($env, $this->exceptedEnvironments));
	}

	if (!empty($allowedEnvironments) && !in_array($this->getEnvironment(), $allowedEnvironments)) {
	    return false;
	} else if (!empty($this->exceptedEnvironments) && in_array($this->getEnvironment(), $this->exceptedEnvironments)) {
	    return false;
	}

	foreach ($this->exceptCallbacks as $callback) {
	    if ($callback()) {
		return false;
	    }
	}

	return true;
    }

    /**
     * Destruct object.
     */
    public function __destruct()
    {
	if ($this->_shouldSleep()) {
	    $this->goToSleep();
	}
    }

    /**
     * Go to sleep implementation.
     *
     * @return void
     */
    abstract protected function goToSleep(): void;
}
