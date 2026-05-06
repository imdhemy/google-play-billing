<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Domain\Purchase\Subscription\OfferPhase;

/**
 * Offer phase information related to a purchase line item.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptionsv2#prorationperiodofferphase
 */
final readonly class ProrationPeriodOfferPhase
{
    public function __construct(public OriginalOfferPhaseType $originalOfferPhaseType)
    {
    }
}
