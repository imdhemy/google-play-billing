<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription;

use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase\BasePriceOfferPhase;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase\FreeTrialOfferPhase;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase\IntroductoryPriceOfferPhase;
use Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase\ProrationPeriodOfferPhase;

/**
 * Offer phase information related to a purchase line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#offerphase
 */
final readonly class OfferPhase
{
    public function __construct(
        public ?ProrationPeriodOfferPhase $prorationPeriod = null,
        public ?FreeTrialOfferPhase $freeTrial = null,
        public ?IntroductoryPriceOfferPhase $introductoryPrice = null,
        public ?BasePriceOfferPhase $basePrice = null,
    ) {
    }
}
