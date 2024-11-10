<?php

namespace Imdhemy\GooglePlay\ValueObjects;

use Carbon\Carbon;
use DateTime;

final readonly class Time
{
    public Carbon $carbon;
    public string $originalValue;

    public function __construct(string $value)
    {
        $this->originalValue = $value;

        $this->carbon = is_numeric($value) ? Carbon::createFromTimestampMs($value) : Carbon::parse($value);
    }

    public function isFuture(): bool
    {
        return Carbon::now()->lessThan($this->carbon);
    }

    public function isPast(): bool
    {
        return Carbon::now()->greaterThan($this->carbon);
    }

    /** @deprecated use the public property {@see self::$carbon} */
    public function getCarbon(): Carbon
    {
        return $this->carbon;
    }

    /** @deprecated depend on carbon instance instead {@see self::$carbon} */
    public function toDateTime(): DateTime
    {
        return $this->carbon->toDateTime();
    }
}
