<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\ValueObjects\AutoRenewingPlan;
use Imdhemy\GooglePlay\ValueObjects\DeferredItemReplacement;
use Imdhemy\GooglePlay\ValueObjects\OfferDetails;
use Imdhemy\GooglePlay\ValueObjects\PrepaidPlan;
use Imdhemy\GooglePlay\ValueObjects\SignupPromotion;
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
