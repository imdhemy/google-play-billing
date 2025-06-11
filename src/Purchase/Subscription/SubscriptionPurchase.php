<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects\PausedStateContext;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPurchaseLineItem;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionState;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Indicates the status of a user's subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#resource:-subscriptionpurchasev2
 */
final readonly class SubscriptionPurchase
{
    /**
     * @param SubscriptionPurchaseLineItem[] $lineItems
     */
    public function __construct(
        public string $kind,
        public string $regionCode,
        public SubscriptionState $subscriptionState,
        public array $lineItems = [],
        public ?Time $startTime = null,
        public ?string $linkedPurchaseToken = null,
        public ?PausedStateContext $pausedStateContext = null,
    ) {
    }
}
