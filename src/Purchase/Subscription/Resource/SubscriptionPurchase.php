<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Purchase\Subscription\Resource;

/**
 * Indicates the status of a user's subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#resource:-subscriptionpurchasev2
 */
final readonly class SubscriptionPurchase
{
    public function __construct(
        public string $kind,
        public string $regionCode,
    ) {
    }
}
