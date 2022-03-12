<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Class AcknowledgementState
 *
 * The acknowledgement state of the subscription product.
 * Possible values are: 0. Yet to be acknowledged 1. Acknowledged
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
     * @return int
     */
    public function getState(): int
    {
        return $this->acknowledged;
    }
}
