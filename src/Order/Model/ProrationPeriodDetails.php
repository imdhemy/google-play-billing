<?php

declare(strict_types=1);

namespace Imdhemy\GooglePlay\Order\Model;

/**
 * Details of a proration period.
 *
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/orders#prorationperioddetails
 */
final readonly class ProrationPeriodDetails
{
    /**
     * @param OfferPhase|null $originalOfferPhase The offer phase of the original line item, when the proration period follows a plan change
     */
    public function __construct(
        public ?OfferPhase $originalOfferPhase = null,
    ) {
    }
}
