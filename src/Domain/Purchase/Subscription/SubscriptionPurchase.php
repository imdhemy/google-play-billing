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
     * @param GooglePlay\SubscriptionPurchaseLineItem[] $lineItems
     */
    public function __construct(
        public string $kind,
        public string $regionCode,
        public GooglePlay\SubscriptionState $subscriptionState,
        public GooglePlay\SubscriptionAcknowledgementState $acknowledgementState,
        public GooglePlay\ExternalAccountIdentifiers $externalAccountIdentifiers,
        public GooglePlay\SubscribeWithGoogleInfo $subscribeWithGoogleInfo,
        public array $lineItems = [],
        public ?GooglePlay\Time $startTime = null,
        public ?string $linkedPurchaseToken = null,
        public ?GooglePlay\PausedStateContext $pausedStateContext = null,
        public ?GooglePlay\CanceledStateContext $canceledStateContext = null,
        public ?GooglePlay\TestPurchase $testPurchase = null,
    ) {
    }
}
