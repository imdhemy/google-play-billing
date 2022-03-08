<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Subscription Price Change
 *
 * Contains the price change information for a subscription that
 * can be used to control the user journey for the price change in the app.
 * This can be in the form of seeking confirmation from the user or
 * tailoring the experience for a successful conversion.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptions#subscriptionpricechange
 */
final class SubscriptionPriceChange
{
    public const STATE_OUTSTANDING = 0;
    public const STATE_ACCEPTED = 1;

    /**
     * @var Price
     */
    private $newPrice;

    /**
     * @var int
     */
    private $state;

    /**
     * SubscriptionPriceChange constructor.
     * @param Price $newPrice
     * @param int $state
     */
    public function __construct(Price $newPrice, int $state)
    {
        $this->newPrice = $newPrice;
        $this->state = $state;
    }

    /**
     * @return Price
     */
    public function getNewPrice(): Price
    {
        return $this->newPrice;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @return bool
     */
    public function isOutstanding(): bool
    {
        return $this->state === self::STATE_OUTSTANDING;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->state === self::STATE_ACCEPTED;
    }
}
