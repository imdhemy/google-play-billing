<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects\Time;

/**
 * Item-level info for a subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#subscriptionpurchaselineitem
 */
final readonly class SubscriptionPurchaseLineItem
{
    public function __construct(
        public string $productId,
        public ?Time $expiryTime = null,
        public ?OfferDetails $offerDetails = null,
        public ?string $latestSuccessfulOrderId = null,
        public ?AutoRenewingPlan $autoRenewingPlan = null,
        public ?PrepaidPlan $prepaidPlan = null,
        public ?DeferredItemReplacement $deferredItemReplacement = null,
        public ?SignupPromotion $signupPromotion = null,
        public ?OfferPhase $offerPhase = null,
    ) {
    }
}
