<?php

declare(strict_types=1);

namespace Newman\LaravelDelay\Contracts;

use Carbon\CarbonInterface;
use Closure;

interface DelayContract
{
    /**
     * Delay for given seconds.
     *
     * @param int $seconds
     * @return $this
     */
    public function forSeconds(int $seconds): static;

    /**
     * Delay for given miliseconds.
     *
     * @param int $miliseconds
     * @return $this
     */
    public function forMiliseconds(int $miliseconds): static;

    /**
     * Delay for given microseconds.
     *
     * @param int $microseconds
     * @return $this
     */
    public function forMicroseconds(int $microseconds): static;

    /**
     * Delay for given seconds.
     *
     * @param int $seconds
     * @return $this
     */
    public function for(int $seconds): static;

    /**
     * Delay for given miliseconds.
     *
     * @param int $miliseconds
     * @return $this
     */
    public function forMs(int $miliseconds): static;

    /**
     * Delay till given datetime.
     *
     * @param CarbonInterface $carbon
     * @return $this
     */
    public function till(CarbonInterface $carbon): static;

    /**
     * Delay only on given environments.
     *
     * @param array<string> $environments
     * @return $this
     */
    public function environments(array $environments): static;

    /**
     * Delay excepting given environments.
     *
     * @param array<string> $environments
     * @return $this
     */
    public function except(array $environments): static;

    /**
     * Except when given Closure returns true.
     *
     * @param Closure $callback
     * @return $this
     */
    public function exceptWhen(Closure $callback): static;
}
