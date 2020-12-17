<?php


namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class AcknowledgementState
 * @package Imdhemy\GooglePlay\ValueObjects
 */
final class AcknowledgementState
{
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
        return $this->acknowledged === 1;
    }

    /**
     * @param int $acknowledged
     * @return static
     */
    public static function fake(int $acknowledged = -1): self
    {
        $acknowledged = $acknowledged === -1 ? rand(0, 1) : $acknowledged;

        return new self($acknowledged);
    }

    /**
     * @return static
     */
    public static function fakeIsAcknowledged(): self
    {
        return new self(1);
    }

    /**
     * @return static
     */
    public static function fakeNotAcknowledged(): self
    {
        return new self(0);
    }
}
