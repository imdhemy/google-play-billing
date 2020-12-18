<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class CancelSurveyReason
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class CancelSurveyReason
{
    const REASON_OTHER = 0;
    const REASON_DO_NOT_USE_ENOUGH = 1;
    const REASON_TECHNICAL = 2;
    const REASON_COST = 3;
    const REASON_FOUND_BETTER_APP = 4;

    /**
     * @var int
     */
    private $value;

    /**
     * CancelSurveyReason constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function other(): bool
    {
        return $this->value === self::REASON_OTHER;
    }

    /**
     * @return bool
     */
    public function doNotUseEnough(): bool
    {
        return $this->value === self::REASON_DO_NOT_USE_ENOUGH;
    }

    /**
     * @return bool
     */
    public function technical(): bool
    {
        return $this->value === self::REASON_TECHNICAL;
    }

    /**
     * @return bool
     */
    public function cost(): bool
    {
        return $this->value === self::REASON_COST;
    }

    /**
     * @return bool
     */
    public function foundBetterApp(): bool
    {
        return $this->value === self::REASON_FOUND_BETTER_APP;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return static
     */
    public static function fake(): self
    {
        return new self(mt_rand(self::REASON_OTHER, self::REASON_FOUND_BETTER_APP));
    }

    /**
     * @return static
     */
    public static function fakeOther(): self
    {
        return new self(self::REASON_OTHER);
    }

    /**
     * @return static
     */
    public static function fakeDoNotUseEnough(): self
    {
        return new self(self::REASON_DO_NOT_USE_ENOUGH);
    }

    /**
     * @return static
     */
    public static function fakeTechnical(): self
    {
        return new self(self::REASON_TECHNICAL);
    }

    /**
     * @return static
     */
    public static function fakeCost(): self
    {
        return new self(self::REASON_COST);
    }

    /**
     * @return static
     */
    public static function fakeFoundBetterApp(): self
    {
        return new self(self::REASON_FOUND_BETTER_APP);
    }
}
