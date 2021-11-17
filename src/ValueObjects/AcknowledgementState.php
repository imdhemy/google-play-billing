<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class AcknowledgementState
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class AcknowledgementState
{
    public const ACKNOWLEDGED = 1;
    public const NOT_ACKNOWLEDGED = 0;

    /**
     * @var int
     */
    private $acknowledged;

    /**
     * AcknowledgementState constructor
     * @param int $acknowledged
     */
    public function __construct(int $acknowledged)
    {
        $this->acknowledged = $acknowledged;
    }

    /**
     * @return bool
     */
    public function isAcknowledged(): bool
    {
        return $this->acknowledged === self::ACKNOWLEDGED;
    }

    /**
     * @param int $acknowledged
     * @return static
     */
    public static function fake(int $acknowledged = -1): self
    {
        $acknowledged = $acknowledged === -self::ACKNOWLEDGED ? rand(
            self::NOT_ACKNOWLEDGED,
            self::ACKNOWLEDGED
        ) : $acknowledged;

        return new self($acknowledged);
    }

    /**
     * @return static
     */
    public static function fakeIsAcknowledged(): self
    {
        return new self(self::ACKNOWLEDGED);
    }

    /**
     * @return static
     */
    public static function fakeNotAcknowledged(): self
    {
        return new self(0);
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->acknowledged;
    }
}
