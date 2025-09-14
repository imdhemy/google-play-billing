<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Subscription Deferral Info.
 *
 * A SubscriptionDeferralInfo contains the data needed to
 * defer a subscription purchase to a future expiry time.
 */
final readonly class SubscriptionDeferralInfo
{
    /**
     * $expectedExpiryTimeMillis - The expected expiry time for the subscription.
     * $desiredExpiryTimeMillis - The desired next expiry time to assign to the subscription, in milliseconds since the Epoch.
     */
    public function __construct(private string $expectedExpiryTimeMillis, private string $desiredExpiryTimeMillis)
    {
    }

    public function getExpectedExpiryTimeMillis(): string
    {
        return $this->expectedExpiryTimeMillis;
    }

    public function getDesiredExpiryTimeMillis(): string
    {
        return $this->desiredExpiryTimeMillis;
    }
}
