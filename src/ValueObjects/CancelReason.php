<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class CancelReason
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class CancelReason
{
    public const REASON_BY_USER = 0;
    public const REASON_BY_SYSTEM = 1;
    public const REASON_REPLACED = 2;
    public const REASON_BY_DEVELOPER = 3;

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
    public function canceledByUser(): bool
    {
        return $this->value === self::REASON_BY_USER;
    }

    /**
     * @return bool
     */
    public function canceledBySystem(): bool
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
    public function canceledByDeveloper(): bool
    {
        return $this->value === self::REASON_BY_DEVELOPER;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
