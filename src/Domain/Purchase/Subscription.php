<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase;

use Imdhemy\GooglePlay\ValueObjects\AcknowledgementState;
use Imdhemy\GooglePlay\ValueObjects\CanceledStateContext;
use Imdhemy\GooglePlay\ValueObjects\ExternalAccountIdentifiers;
use Imdhemy\GooglePlay\ValueObjects\PausedStateContext;
use Imdhemy\GooglePlay\ValueObjects\SubscribeWithGoogleInfo;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionPurchaseLineItem;
use Imdhemy\GooglePlay\ValueObjects\SubscriptionState;
use Imdhemy\GooglePlay\ValueObjects\TestPurchase;
use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Indicates the status of a user's subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#resource:-subscriptionpurchasev2
 */
final readonly class Subscription
{
    /**
     * @param SubscriptionPurchaseLineItem[] $lineItems
     */
    public function __construct(
        public string $kind,
        public string $regionCode,
        public SubscriptionState $subscriptionState,
        public AcknowledgementState $acknowledgementState,
        public ExternalAccountIdentifiers $externalAccountIdentifiers,
        public SubscribeWithGoogleInfo $subscribeWithGoogleInfo,
        public array $lineItems = [],
        public ?Time $startTime = null,
        public ?string $linkedPurchaseToken = null,
        public ?PausedStateContext $pausedStateContext = null,
        public ?CanceledStateContext $canceledStateContext = null,
        public ?TestPurchase $testPurchase = null,
    ) {
    }
}
