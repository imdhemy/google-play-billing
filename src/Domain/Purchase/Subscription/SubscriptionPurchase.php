<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects as GooglePlay;

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
        public SubscriptionAcknowledgementState $acknowledgementState,
        public ExternalAccountIdentifiers $externalAccountIdentifiers,
        public SubscribeWithGoogleInfo $subscribeWithGoogleInfo,
        public array $lineItems = [],
        public ?GooglePlay\Time $startTime = null,
        public ?string $linkedPurchaseToken = null,
        public ?PausedStateContext $pausedStateContext = null,
        public ?CanceledStateContext $canceledStateContext = null,
        public ?TestPurchase $testPurchase = null,
    ) {
    }
}
