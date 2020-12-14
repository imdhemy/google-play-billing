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
     * @param int $timestampMs
     */
    public function __construct(int $timestampMs)
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

    /**
     * @return static
     */
    public static function fake(): self
    {
        $sign = ["-", "+"][mt_rand(0, 1)];
        $years = mt_rand(0, 10);
        $month = mt_rand(1, 12);
        $day = mt_rand(1, 28);

        $datetime = (new DateTime())
            ->modify("$sign $years years")
            ->modify("$sign $month months")
            ->modify("$sign $day days");

        return new self($datetime->getTimestamp() * 1000);
    }

    /**
     * @param DateTime $start
     * @param DateTime $end
     * @return static
     */
    public static function fakeBetween(DateTime $start, DateTime $end): self
    {
        $timeMs = mt_rand($start->getTimestamp(), $end->getTimestamp()) * 1000;

        return new self($timeMs);
    }

    /**
     * @param DateTime $start
     * @return static
     */
    public static function fakeAfter(DateTime $start): self
    {
        $start = $start->getTimestamp();
        $timeMs = mt_rand($start, $start + 365 * 24 * 60 * 60) * 1000;

        return new self($timeMs);
    }

    /**
     * @param DateTime $end
     * @return static
     */
    public static function fakeBefore(DateTime $end): self
    {
        $end = $end->getTimestamp();
        $timeMs = mt_rand($end - 365 * 24 * 60 * 60, $end) * 1000;

        return new self($timeMs);
    }

    /**
     * @return static
     */
    public static function fakeFuture(): self
    {
        return self::fakeAfter(new DateTime());
    }

    /**
     * @return static
     */
    public static function fakePast(): self
    {
        return self::fakeBefore(new DateTime());
    }
}
