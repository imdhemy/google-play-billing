<?php


namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class CancelReason
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class CancelReason
{
    const REASON_BY_USER = 0;
    const REASON_BY_SYSTEM = 1;
    const REASON_REPLACED = 2;
    const REASON_BY_DEVELOPER = 3;

    /**
     * @var int
     */
    private $value;

    /**
     * CancelReason constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function cancelledByUser(): bool
    {
        return $this->value === self::REASON_BY_USER;
    }

    /**
     * @return bool
     */
    public function cancelledBySystem(): bool
    {
        return $this->value === self::REASON_BY_SYSTEM;
    }

    /**
     * @return bool
     */
    public function replacedByNewSubscription(): bool
    {
        return $this->value === self::REASON_REPLACED;
    }

    /**
     * @return bool
     */
    public function cancelledByDeveloper(): bool
    {
        return $this->value === self::REASON_BY_DEVELOPER;
    }

    /**
     * @return static
     */
    public static function fake(): self
    {
        return new self(mt_rand(self::REASON_BY_USER, self::REASON_BY_DEVELOPER));
    }

    /**
     * @return static
     */
    public static function fakeCancelledByUser(): self
    {
        return new self(self::REASON_BY_USER);
    }

    /**
     * @return static
     */
    public static function fakeCancelledBySystem(): self
    {
        return new self(self::REASON_BY_SYSTEM);
    }

    /**
     * @return static
     */
    public static function fakeReplacedByNewSubscription(): self
    {
        return new self(self::REASON_REPLACED);
    }

    /**
     * @return static
     */
    public static function fakeCancelledByDeveloper(): self
    {
        return new self(self::REASON_BY_DEVELOPER);
    }
}
