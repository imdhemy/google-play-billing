<?php

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Subscription Price Change.
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

    public const ATTR_NEW_PRICE = 'newPrice';
    public const ATTR_STATE = 'state';

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
     */
    public function __construct(Price $newPrice, int $state)
    {
        $this->newPrice = $newPrice;
        $this->state = $state;
    }

    public function getNewPrice(): Price
    {
        return $this->newPrice;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function isOutstanding(): bool
    {
        return self::STATE_OUTSTANDING === $this->state;
    }

    public function isAccepted(): bool
    {
        return self::STATE_ACCEPTED === $this->state;
    }

    /**
     * Get array representation of current value.
     */
    public function toArray(): array
    {
        return [
            self::ATTR_NEW_PRICE => $this->newPrice->toArray(),
            self::ATTR_STATE => $this->state,
        ];
    }
}
