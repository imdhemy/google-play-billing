<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\ValueObjects;

/**
 * Item-level info for a subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#subscriptionpurchaselineitem
 */
final readonly class SubscriptionPurchaseLineItem
{
    public function __construct(
        public string $productId,
        public Time $expiryTime,
        public OfferDetails $offerDetails,
        public ?string $latestSuccessfulOrderId = null,
        public ?AutoRenewingPlan $autoRenewingPlan = null,
        public ?PrepaidPlan $prepaidPlan = null,
        public ?DeferredItemReplacement $deferredItemReplacement = null,
        public ?SignupPromotion $signupPromotion = null,
    ) {
    }
}
