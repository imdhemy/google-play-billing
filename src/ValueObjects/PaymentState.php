<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Payment State
 * The payment state of the subscription.
 * Possible values are:
 * 0. Payment pending
 * 1. Payment received
 * 2. Free trial
 * 3. Pending deferred upgrade/downgrade
 * Not present for canceled, expired subscriptions.
 */
final class PaymentState
{
    public const PAYMENT_STATE_PENDING = 0;
    public const PAYMENT_STATE_RECEIVED = 1;
    public const PAYMENT_STATE_FREE_TRIAL = 2;
    public const PAYMENT_STATE_DEFERRED = 3;

    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->value === self::PAYMENT_STATE_PENDING;
    }

    /**
     * @return bool
     */
    public function isReceived(): bool
    {
        return $this->value === self::PAYMENT_STATE_RECEIVED;
    }

    /**
     * @return bool
     */
    public function isFreeTrial(): bool
    {
        return $this->value === self::PAYMENT_STATE_FREE_TRIAL;
    }

    /**
     * @return bool
     */
    public function isDeferred(): bool
    {
        return $this->value === self::PAYMENT_STATE_DEFERRED;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }
}
