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
     * @param integer $timestamp
     */
    public function __construct(int $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return boolean
     */
    public function isFuture(): bool
    {
        $now = new DateTime('now');
        return $this->timestamp > $now->getTimestamp()*1000;
    }

    /**
     * @return boolean
     */
    public function isPast(): bool
    {
        $now = new DateTime('now');
        return $this->timestamp < $now->getTimestamp()*1000;
    }
}
