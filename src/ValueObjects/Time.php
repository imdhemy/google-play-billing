<?php


namespace Imdhemy\GooglePlay\ValueObjects;

use DateTime;

final class Time
{
    /**
     * @var int
     */
    private $timestamp;

    /**
     * Time constructor
     *
     * @param int $timestamp
     */
    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return bool
     */
    public function isFuture(): bool
    {
        $now = new DateTime('now');

        return $this->timestamp > $now->getTimestamp() * 1000;
    }

    /**
     * @return bool
     */
    public function isPast(): bool
    {
        $now = new DateTime('now');

        return $this->timestamp < $now->getTimestamp() * 1000;
    }
}
