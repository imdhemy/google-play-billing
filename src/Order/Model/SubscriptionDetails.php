<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

use DateTimeImmutable;

/**
 * Details of a subscription purchase.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#subscriptiondetails
 */
final readonly class SubscriptionDetails
{
    /**
     * @param string|null            $basePlanId             The base plan ID of the subscription
     * @param string|null            $offerId                The offer ID for the current subscription offer
     * @param OfferPhase|null        $offerPhase             Deprecated by Google; use offerPhaseDetails instead
     * @param OfferPhaseDetails|null $offerPhaseDetails      The pricing phase for the entitlement period funded by this order
     * @param DateTimeImmutable|null $servicePeriodStartTime The start of the billing period funded by this order
     * @param DateTimeImmutable|null $servicePeriodEndTime   The end of the billing period funded by this order
     */
    public function __construct(
        public ?string $basePlanId = null,
        public ?string $offerId = null,
        public ?OfferPhase $offerPhase = null,
        public ?OfferPhaseDetails $offerPhaseDetails = null,
        public ?DateTimeImmutable $servicePeriodStartTime = null,
        public ?DateTimeImmutable $servicePeriodEndTime = null,
    ) {
    }
}
