<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Subscription Deferral Info.
 *
 * A SubscriptionDeferralInfo contains the data needed to
 * defer a subscription purchase to a future expiry time.
 */
final class SubscriptionDeferralInfo
{
    /** @deprecated  */
    public const string EXPECTED_EXPIRY_TIME_MILLIS = 'expectedExpiryTimeMillis';
    /** @deprecated  */
    public const string DESIRED_EXPIRY_TIME_MILLIS = 'desiredExpiryTimeMillis';

    /**
     * The expected expiry time for the subscription.
     */
    private string $expectedExpiryTimeMillis;

    /**
     * The desired next expiry time to assign to the subscription, in milliseconds since the Epoch.
     */
    private string $desiredExpiryTimeMillis;

    public function __construct(string $expectedExpiryTimeMillis, string $desiredExpiryTimeMillis)
    {
        $this->expectedExpiryTimeMillis = $expectedExpiryTimeMillis;
        $this->desiredExpiryTimeMillis = $desiredExpiryTimeMillis;
    }

    /** @deprecated  */
    public function toArray(): array
    {
        return [
            self::EXPECTED_EXPIRY_TIME_MILLIS => $this->expectedExpiryTimeMillis,
            self::DESIRED_EXPIRY_TIME_MILLIS => $this->desiredExpiryTimeMillis,
        ];
    }
}
