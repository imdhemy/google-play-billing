<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Price change related information of a subscription item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#subscriptionitempricechangedetails
 */
final readonly class SubscriptionItemPriceChangeDetails
{
    public function __construct(
        public Money $newPrice,
        public string $priceChangeMode,
        public string $priceChangeState,
        public ?Time $expectedNewPriceChargeTime,
    ) {
    }
}
