<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * Details of the pricing phase for the entitlement period funded by an order.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#offerphasedetails
 */
final readonly class OfferPhaseDetails
{
    /**
     * @param BaseDetails|null              $baseDetails              The order funds a base price period
     * @param IntroductoryPriceDetails|null $introductoryPriceDetails The order funds an introductory pricing period
     * @param FreeTrialDetails|null         $freeTrialDetails         The order funds a free trial period
     * @param ProrationPeriodDetails|null   $prorationPeriodDetails   The order funds a proration period
     */
    public function __construct(
        public ?BaseDetails $baseDetails = null,
        public ?IntroductoryPriceDetails $introductoryPriceDetails = null,
        public ?FreeTrialDetails $freeTrialDetails = null,
        public ?ProrationPeriodDetails $prorationPeriodDetails = null,
    ) {
    }
}
