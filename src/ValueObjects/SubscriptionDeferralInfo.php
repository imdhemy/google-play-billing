<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Subscription Deferral Info
 *
 * A SubscriptionDeferralInfo contains the data needed to
 * defer a subscription purchase to a future expiry time.
 */
final class SubscriptionDeferralInfo
{
    public const EXPECTED_EXPIRY_TIME_MILLIS = 'expectedExpiryTimeMillis';
    public const DESIRED_EXPIRY_TIME_MILLIS = 'desiredExpiryTimeMillis';
    /**
     * The expected expiry time for the subscription.
     * @var string
     */
    private $expectedExpiryTimeMillis;

    /**
     * The desired next expiry time to assign to the subscription, in milliseconds since the Epoch.
     * @var string
     */
    private $desiredExpiryTimeMillis;

    /**
     * @param string $expectedExpiryTimeMillis
     * @param string $desiredExpiryTimeMillis
     */
    public function __construct(string $expectedExpiryTimeMillis, string $desiredExpiryTimeMillis)
    {
        $this->expectedExpiryTimeMillis = $expectedExpiryTimeMillis;
        $this->desiredExpiryTimeMillis = $desiredExpiryTimeMillis;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::EXPECTED_EXPIRY_TIME_MILLIS => $this->expectedExpiryTimeMillis,
            self::DESIRED_EXPIRY_TIME_MILLIS => $this->desiredExpiryTimeMillis,
        ];
    }
}
