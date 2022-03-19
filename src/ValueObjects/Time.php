<?php

namespace Imdhemy\GooglePlay\ValueObjects;

use Carbon\Carbon;
use DateTime;

final class Time
{
    /**
     * @var Carbon
     */
    private $carbon;

    /**
     * Time constructor
     *
     * @param float|int|string $timestampMs
     */
    public function __construct($timestampMs)
    {
        $this->carbon = Carbon::createFromTimestampMs($timestampMs);
    }

    /**
     * @return bool
     */
    public function isFuture(): bool
    {
        return Carbon::now()->lessThan($this->carbon);
    }

    /**
     * @return bool
     */
    public function isPast(): bool
    {
        return Carbon::now()->greaterThan($this->carbon);
    }

    /**
     * @return Carbon
     */
    public function getCarbon(): Carbon
    {
        return $this->carbon;
    }

    /**
     * @return DateTime
     */
    public function toDateTime(): DateTime
    {
        return $this->carbon->toDateTime();
    }
}
