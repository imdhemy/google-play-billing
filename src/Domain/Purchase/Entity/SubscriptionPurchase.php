<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Entity;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\AcknowledgementState;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\CanceledStateContext;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\ExternalAccountIdentifiers;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\PausedStateContext;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscribeWithGoogleInfo;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionPurchaseLineItem;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\SubscriptionState;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\TestPurchase;
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
        public AcknowledgementState $acknowledgementState,
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
